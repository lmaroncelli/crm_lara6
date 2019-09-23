<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\RagioneSociale;
use App\Societa;
use App\Utility;
use Illuminate\Http\Request;

class ClientiFatturazioniController extends Controller
{
	public function index($cliente_id)
		{
		$cliente = Cliente::with(['societa.ragioneSociale.localita'])->find($cliente_id);

		////////////////////////////////////////////////////////////
		// definire gli id delle società del cliente da escludere //
		// e passarli alla funzione getListForSelectModal()				//
		////////////////////////////////////////////////////////////
		
		$societa_ids =  $cliente->societa->pluck('id')->toArray();		

		$ragioneSociale = RagioneSociale::getListForSelectModal($societa_ids);

		return view('clienti-fatturazioni.index', compact('cliente','ragioneSociale'));
		}


	public function associaSocietaAjax(Request $request)
		{
		$cliente_id = $request->get('cliente_id');
		$societa_id = $request->get('societa_id');

		$societa = Societa::find($societa_id);

		$societa->cliente_id = $cliente_id;
		
		$societa->save();

		echo "ok";


		}


	public function edit($societa_id)
		{
		$societa = Societa::with(['ragioneSociale', 'cliente'])->find($societa_id);

		$cliente = $societa->cliente;

		return view('clienti-fatturazioni.form', compact('societa','cliente'));
		}


	public function update(Request $request, $societa_id)
		{
		
		$validation_arr = ['nome_rag_soc' => 'required'];

		////////////////////////////////////////////////////////////////////
		// controllo piva solo se localita NON è PROVINCIA DI  San Marino //
		////////////////////////////////////////////////////////////////////
		if( !Utility::isLocalitaInRSM($request->get('localita_id')) )
			{
			$validation_arr['piva'] = 'digits:11';
			}

		$validatedData = $request->validate($validation_arr);

		$societa = Societa::find($societa_id);
		$societa->fill(['banca' => $request->get('banca'), 'abi' => $request->get('abi'), 'cab' => $request->get('cab'), 'iban' => $request->get('iban'), 'note' => $request->get('note')]);
		$societa->save();

		$ragioneSociale = $societa->ragioneSociale;
		$ragioneSociale->fill([ 'nome' => $request->get('nome_rag_soc'), 'indirizzo' => $request->get('indirizzo'), 'localita_id' => $request->get('localita_id'), 'cap' => $request->get('cap'), 'piva' => $request->get('piva'), 'cf' => $request->get('cf'), 'pec' => $request->get('pec'), 'codice_sdi' => $request->get('codice_sdi') ]);
		$ragioneSociale->save();

		return redirect()->route('clienti-fatturazioni', $societa->cliente_id)->with('status', 'Ragione Sociale modificata correttamente!');

		}

	public function destroy(Request $request)
		{
		dd('Elimina!!!');
		}
}
