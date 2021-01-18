<?php

namespace App\Http\Controllers;

use App\User;
use App\Cliente;
use App\Utility;
use Illuminate\Http\Request;

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
		
			//dd($request->all());

			// E' un CLIENTE ESISTENTE
			if ($request->has('cliente_id') && $request->get('cliente_id') != '') 
				{
					
				$data = array (
					'user_id' => $request->id_commerciale,
					'cliente_id' => $request->cliente_id,
					'nome_hotel' => $request->cliente,
					'localita' => $request->localita,
					'sms' => $request->sms,
					'whatsapp' => $request->whatsapp,
					'skype' => $request->skype
					);
				
				}
			else {
				
			}
			
			
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
        //
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


}
