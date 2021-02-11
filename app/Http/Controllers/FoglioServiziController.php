<?php

namespace App\Http\Controllers;

use PDF;
use SetaPDF_Core_Document;
use SetaPDF_Core_Reader_File;
use SetaPDF_Core_Writer_File;
use App\User;
use App\Cliente;
use App\Utility;
use App\InfoPiscina;
use App\FoglioServizi;
use App\ServizioFoglio;
use App\CentroBenessere;
use App\GruppoServiziFoglio;
use Illuminate\Http\Request;
use App\ServizioAggiuntivoFoglio;
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
    public function index()
    {
        //
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

        
        return view('foglio_servizi.form', compact('foglio', 'commerciale_contratto', 'infoPiscina', 'centroBenessere', 'gruppiServizi', 'ids_servizi_associati', 'serv_agg'));


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
                                        'cliente.categoria'
                                ])
                                ->find($id);


        return view('foglio_servizi.foglio_servizi_pdf', compact('foglio'));

        //$pdf = PDF::loadView('contratti_digitali.contratto_pdf', compact('contratto', 'commerciale_contratto', 'servizi_assoc', 'totali', 'n_servizi_per_pagina', 'chunk_servizi', 'n_sottotab'));

    }


    public function creaPdfAjax(Request $request) {

        $foglio_id = $request->get('foglio_id');

        $pdf = $this->_crea_pdf($foglio_id);

        return 'ok';
    }


}
