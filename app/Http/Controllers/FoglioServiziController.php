<?php

namespace App\Http\Controllers;

use PDF;
use App\User;
use App\Cliente;
use App\Utility;
use SignatureField;
use App\InfoPiscina;
use App\FoglioServizi;
use App\ServizioFoglio;
use App\CentroBenessere;
use SetaPDF_Core_Document;
use App\GruppoServiziFoglio;
use Illuminate\Http\Request;
use SetaPDF_Core_Reader_File;
use SetaPDF_Core_Writer_File;
use App\ServizioAggiuntivoFoglio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FoglioServiziRequest;

class FoglioServiziController extends Controller
{


private function fieldsPiscina() {
    $fields = ['sup',
                'h',
                'h_min',
                'h_max',
                'aperto_dal',
                'aperto_al',
                'aperto_annuale',
                'espo_sole',
                'espo_sole_tutto_giorno',
                'posizione',
                'coperta',
                'riscaldata',
                'salata',
                'idro',
                'idro_cervicale',
                'scivoli',
                'trampolino',
                'aperitivi',
                'getto_bolle',
                'cascata',
                'musica_sub',
                'wi_fi',
                'pagamento',
                'vasca_posizione',
                'salvataggio',
                'nuoto_contro',
                'peculiarita_piscina',
                'lettini_dispo',
                'vasca_bimbi_h',
                'vasca_bimbi_sup',
                'vasca_idro_posti_dispo',
                'vasca_idro_riscaldata',
                'vasca_pagamento',
                'vasca_idro_n_dispo',
                'vasca_bimbi_riscaldata'];

    return $fields;
}


    private function fieldsBenessere() {

        $fields = [
            'sup_b',
            'area_fitness',
            'sup_fitness',
            'aperto_dal_b',
            'aperto_al_b',
            'aperto_annuale_b',
            'a_pagamento',
            'in_hotel',
            'distanza_hotel',
            'eta_minima',
            'obbligo_prenotazione',
            'uso_esclusivo',
            'piscina_benessere',
            'idromassaggio',
            'sauna_finlandese',
            'bagno_turco',
            'docce_emozionali',
            'cascate_ghiaccio',
            'aromaterapia',
            'percorso_kneipp',
            'cromoterapia',
            'massaggi',
            'trattamenti_estetici',
            'area_relax',
            'letto_marmo_riscaldato',
            'stanza_sale',
            'kit_benessere',
            'peculiarita'
        ];

        return $fields;        
    }


    private function fieldsServiziENote(){
        $servizi_e_note = ServizioFoglio::pluck('id')->toArray();
        foreach (ServizioFoglio::pluck('id')->toArray() as $id) {
            $servizi_e_note[] = 'nota_servizio_'.$id;
        }

        return $servizi_e_note;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $all = null)
    {
        // campo libero
        $qf = $request->get('qf');
        $field = $request->get('field');

        $orderby = $request->get('orderby');
        $order = $request->get('order');


        if (is_null($order)) {
            $order = 'desc';
        }

        if (is_null($orderby)) {
            $orderby = 'id';
        }

        if (!is_null($all) && $all == 'all') {
            $url_index = 'foglio-servizi/all';
            $fogli = FoglioServizi::withoutGlobalScope('data_creazione')->with(['commerciale', 'cliente']);
            $all = 1;
        } else {
            $url_index = 'foglio-servizi';
            $fogli = FoglioServizi::with(['commerciale', 'cliente']);
            $all = 0;
        }

        $join_users = 0;
        $join_clienti = 0;

        if (!is_null($qf) && $field != '0') {
            if ($field == 'commerciale') {
                $fogli = $fogli
                    ->select(DB::raw('tblFogliServizi.*, users.name as nome_commerciale'))
                    ->join('users', 'users.id', '=', 'tblFogliServizi.user_id')
                    ->with([
                        'commerciale',
                        'cliente'
                    ])
                    ->where('users.name', 'LIKE', '%' . $qf . '%');


                $join_users = 1;
            } elseif ($field == 'cliente') {
                $fogli = $fogli
                    ->select(DB::raw('tblFogliServizi.*, tblClienti.nome as nome_cliente'))
                    ->leftjoin('tblClienti', 'tblClienti.id', '=', 'tblFogliServizi.cliente_id')
                    ->with([
                        'commerciale',
                        'cliente'
                    ])
                    ->where('tblClienti.nome', 'LIKE', '%' . $qf . '%');

                $join_clienti = 1;
            }
        }

        if ($orderby == 'nome_commerciale' && !$join_users) {
            $fogli = $fogli
                ->select(DB::raw('tblFogliServizi.*, users.name as nome_commerciale'))
                ->join('users', 'users.id', '=', 'tblFogliServizi.user_id')
                ->with([
                    'commerciale',
                    'cliente'
                ]);
        } elseif ($orderby == 'nome_cliente' && !$join_clienti) {
            $fogli = $fogli
                ->select(DB::raw('tblFogliServizi.*, tblClienti.nome as nome_cliente'))
                ->leftjoin('tblClienti', 'tblClienti.id', '=', 'tblFogliServizi.cliente_id')
                ->with([
                    'commerciale',
                    'cliente'
                ]);
        }

        $fogli = $fogli->orderBy($orderby, $order);

        $to_append = ['order' => $order, 'orderby' => $orderby];

        if (!is_null($qf) && $field != '0') {
            $to_append['qf'] = $qf;
            $to_append['field'] = $field;
        }


        $fogli = $fogli->paginate(15)->setpath('')->appends($to_append);

        $campi_fogli_search[] = 'campo in cui cercare';
        $campi_fogli_search['commerciale'] = 'commerciale';
        $campi_fogli_search['cliente'] = 'cliente';

        return view('foglio_servizi.index', compact('fogli', 'campi_fogli_search', 'url_index', 'all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clienti_autocomplete_js = Utility::getAutocompleteJs();

        $utenti_commerciali = User::commerciale()->orderBy('name')->get();

        return view('foglio_servizi.form_init', compact('clienti_autocomplete_js', 'utenti_commerciali'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
			$data = array(
				'user_id' => $request->id_commerciale,
				'nome_hotel' => $request->cliente,
				'localita' => $request->localita,
				'sms' => $request->sms,
				'whatsapp' => $request->whatsapp,
				'skype' => $request->skype
			);

			// E' un CLIENTE ESISTENTE
			if ($request->has('cliente_id') && $request->get('cliente_id') != '') 
				{
				$data['cliente_id'] = $request->cliente_id;
				}
			else 
				{
				$data['cliente_id'] = -1;
				}


			$foglio = FoglioServizi::create($data);

			return redirect()->route('foglio-servizi.edit', $foglio->id);
			
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $foglio = FoglioServizi::with('cliente')->find($id);

        // commerciale selezionato
        $commerciale_contratto = User::find($foglio->user_id)->name;



		$infoPiscina = $foglio->infoPiscina;
		
		// se infoPiscina non esiste la creo vuota e la associo al foglio
		if ( is_null($infoPiscina) ) 
		{
			$infoPiscina = new InfoPiscina;

			$infoPiscina->foglioServizi()->associate($foglio);

			$infoPiscina->save();
        }



        $centroBenessere = $foglio->centroBenessere;

        // se infoPiscina non esiste la creo vuota e la associo al foglio
        if (is_null($centroBenessere)) {
            
            $centroBenessere = new CentroBenessere;

            $centroBenessere->foglioServizi()->associate($foglio);

            $centroBenessere->save();
        }


        // elenco GruppiServizi 
        $gruppiServizi = GruppoServiziFoglio::with(['elenco_servizi'])->orderBy('order')->get();

        // ids servizi associati al foglio
        $ids_servizi_associati = $foglio->servizi()->pluck('tblFoglioAssociaServizi.note', 'tblFoglioAssociaServizi.servizio_id')->toArray();



        // servizi aggiuntivi associati al foglio
        $serviziAggiuntivi = $foglio->servizi_aggiuntivi;

        $serv_agg = [];

        foreach ($serviziAggiuntivi as $serv) {
            $serv_agg[$serv->gruppo_id][] = $serv->id.'|'.$serv->nome;
        }

        /*
        dd($serv_agg);
        array:5 [▼
                1 => array:2 [▼
                    0 => "9074|servizio spiaggia"
                    1 => "9075|idromassaggio"
                ]
                4 => array:2 [▼
                    0 => "9076|cucina dietetica"
                    1 => "9077|cucina per intolleranze"
                ]
                10 => array:1 [▼
                    0 => "9078|servizio spiaggia con pedana semovibile e carrozzina disabili da mare"
                ]
                14 => array:1 [▼
                    0 => "9079|parcheggio in hotel solo  per carico e scarico"
                ]
                2 => array:2 [▼
                    0 => "9080|centro massaggi in hotel adiacente di stessa gestione"
                    1 => "9081|parrucchiera in hotel adiacente di stessa gestione"
                ]
        ]
        */

        $exists = Storage::disk('fogliservizi')->exists($foglio->nome_file . '_firmato.pdf');

        
        return view('foglio_servizi.form', compact('foglio', 'commerciale_contratto', 'infoPiscina', 'centroBenessere', 'gruppiServizi', 'ids_servizi_associati', 'serv_agg', 'exists'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FoglioServiziRequest $request, $id)
    {
        $foglio = FoglioServizi::find($id);

        $to_exclude = array_merge($this->fieldsPiscina(), $this->fieldsBenessere(), $this->fieldsServiziENote(), ['dal', 'al', 'data_firma', '_token', '_method']);

        //? Mantengo intatta la request
        $my_request = $request;
        
        $my_request = $my_request->except($to_exclude);
                

        $foglio->update($my_request);

        //? gestione servizi
        $servizi_sync = [];

        foreach (ServizioFoglio::pluck('id')->toArray() as $servizio_id) {

            if( $request->has($servizio_id) && $request->get($servizio_id) == '1' ) {
                if ($request->get('nota_servizio_'. $servizio_id) == '') {
                    $servizi_sync[$servizio_id] = $request->get($servizio_id);
                } else {
                    $servizi_sync[$servizio_id] = ['note' => $request->get('nota_servizio_' . $servizio_id)];
                }
            }
        }

        $foglio->servizi()->sync($servizi_sync);



        //? gestione piscina
        $foglio->infoPiscina()->delete();
        
        if($request->piscina == '1') {
            
            $values_piscina = [];
            
            foreach ($this->fieldsPiscina() as $value) {
                $values_piscina[$value] = $request->get($value);
            }

            $infoPiscina = new InfoPiscina($values_piscina);

            $infoPiscina->foglioServizi()->associate($foglio);

            $infoPiscina->save();
    
        }


        //? gestione centro benessere
        $foglio->centroBenessere()->delete();
        
        if ($request->benessere == '1') {

            $values_benessere = [];

            foreach ($this->fieldsBenessere() as $value) {
                $values_benessere[$value] = $request->get($value);
            }

            $centroBenessere = new CentroBenessere($values_benessere);

            $centroBenessere->foglioServizi()->associate($foglio);

            $centroBenessere->save();
        }
        
        return redirect()->route('foglio-servizi.edit', $foglio->id)->with('status', 'Foglio modificato correttamente!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




    public function loadClienteFoglioServiziAjax(Request $request)
    {
			// nella forma 1421 - Hotel Fantasy - Rimini
			$item = $request->get('item');

			list($id_info, $name) = explode("-", $item);

			$cliente = Cliente::with('localita')->byIdInfo($id_info)->first();

			$data = [];

			$data['cliente_id'] = $cliente->id;

			$data['cliente'] = $cliente->nome;
			$data['localita'] = $cliente->localita->nome;
			$data['sms'] = $cliente->sms;
			$data['whatsapp'] = $cliente->whatsapp;
			$data['skype'] = $cliente->skype;

			echo json_encode($data);

    }

    public function  addServizioAggiuntivoAjax(Request $request) {

        $gruppo_id =  $request->gruppo_id;
        $nome_servizio = $request->nome_servizio;
        $foglio_id = $request->foglio_id;

        try {
            $servizo_aggiuntivo = ServizioAggiuntivoFoglio::create([
                'foglio_id' => $foglio_id,
                'gruppo_id' => $gruppo_id,
                'nome' => $nome_servizio
            ]);
            
            return view('foglio_servizi._riga_servizio_agg', ['id_serv_agg' => $servizo_aggiuntivo->id, 'nome_serv_agg' => $servizo_aggiuntivo->nome]);

        } catch (\Exception $e) {

            echo $e->getMessage();
        } 

    }

    public function delServizioAggiuntivoAjax(Request $request) {

        $id = $request->id;

        ServizioAggiuntivoFoglio::destroy($id);

        echo "ok";

    }



    private function _crea_pdf($id) {

        $foglio = FoglioServizi::with(['commerciale',
                                        'infoPiscina',
                                        'centroBenessere',
                                        'cliente.categoria',
                                        'cliente.localita',
                                ])
                                ->find($id);

        $nome_file = $foglio->nome_file;

        // ids servizi associati al foglio
        $ids_servizi_associati = $foglio->servizi()->pluck('tblFoglioAssociaServizi.note', 'tblFoglioAssociaServizi.servizio_id')->toArray();

        // elenco GruppiServizi 
        $gruppiServizi = GruppoServiziFoglio::with(['elenco_servizi'])->orderBy('order')->get();

        // ? DOMPDF and ICONS https://paulcracknell.com/87/laravel-dom-pdf-issues-font-awesome-and-a-unicode-work-around/
        // ? &#9745; check     
        // ? &#9744; check vuoto

        //return view('foglio_servizi.foglio_servizi_pdf', compact('foglio','ids_servizi_associati','gruppiServizi));

        $pdf = PDF::loadView('foglio_servizi.foglio_servizi_pdf', compact('foglio', 'ids_servizi_associati', 'gruppiServizi'));

        //return $pdf->download('invoice.pdf');

        $filepdf_path = storage_path('app/public/fogliservizi') . '/' . $nome_file . '.pdf';
        $filepdf_firmato_path = storage_path('app/public/fogliservizi') . '/' . $nome_file . '_firmato.pdf';

        $pdf->save($filepdf_path);

        $reader = new SetaPDF_Core_Reader_File($filepdf_path);
        $writer = new SetaPDF_Core_Writer_File($filepdf_firmato_path);
        $document = SetaPDF_Core_Document::load($reader, $writer);


        $pages = $document->getCatalog()->getPages();
        $pageCount = $pages->count();


        ////////////////////////////////////////
        // aggiungo le firme in ultima pagina //
        ////////////////////////////////////////
        SignatureField::add(
            $document,
            'CLIENTE 1',
            $pageCount,
            SignatureField::POSITION_RIGHT_BOTTOM,
            array('x' => -40, 'y' => 5),
            200,
            50
        );


        // save and finish
        $document->save()->finish();


        return $pdf;

    }


    public function creaPdfAjax(Request $request) {

        $foglio_id = $request->get('foglio_id');

        $pdf = $this->_crea_pdf($foglio_id);

        echo 'ok';
    }


}
