<?php

namespace App\Http\Controllers;

use App\User;
use App\Cliente;
use App\Utility;
use App\InfoPiscina;
use App\FoglioServizi;
use App\CentroBenessere;
use App\GruppoServiziFoglio;
use Illuminate\Http\Request;
use App\ServizioAggiuntivoFoglio;

class FoglioServiziController extends Controller
{
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
    public function update(Request $request, $id)
    {
        //
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


}
