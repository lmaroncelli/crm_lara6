<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Servizio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientiServiziController extends Controller
{

	
		public function archiviaAjax(Request $request)
			{
			
			$servizio_id = $request->get('servizio_id');
			$archiviato = $request->get('archiviato');
			$servizio = Servizio::findOrFail($servizio_id);
			$servizio->archiviato = $archiviato;
			$servizio->save();
			
			echo 'ok';
			}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $cliente_id, $venduti = false)
			{
			
			$cliente = Cliente::with(['societa.ragioneSociale.localita'])->find($cliente_id);
			$bread = [route('clienti.index') => 'Cienti', $cliente->nome];

			$orderby = $request->get('orderby','id');
			$order = $request->get('order','desc');

			if (!$venduti) 
				{
				$servizi = Servizio::with(['prodotto','fattura'])->notArchiviato()->where('cliente_id', $cliente_id);
				} 
			else 
				{
				$servizi = Servizio::with(['prodotto','fattura'])->archiviato()->where('cliente_id', $cliente_id);
				}
			
			if ($orderby == 'nome_prodotto') 
				{
				
				$servizi = $servizi
									->select(DB::raw('tblServizi.*, tblProdotti.nome as nome_prodotto'))
									->join('tblProdotti', 'tblProdotti.id', '=', 'tblServizi.prodotto_id')
									->with([
										'prodotto',
										'fattura'
										])
									->orderBy($orderby,$order);
				
				}
			elseif($orderby == 'data_inizio' || $orderby == 'data_fine')
				{
				$servizi = $servizi->orderBy($orderby,$order);
				}
					
			$servizi = $servizi->get();
			
			return view('clienti-servizi.index', compact('cliente', 'bread','servizi','venduti'));
			
		}
		
		public function archiviati(Request $request, $cliente_id)
    {
			return $this->index($request, $cliente_id, $venduti = true);
		}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
			$servizio = Servizio::find($id);
			$venduti = $servizio->archiviato;
			$cliente_id = $servizio->cliente_id;
			$servizio->delete();
			
			if(!$venduti)
				{
				return redirect()->route('clienti-servizi',['cliente_id' => $cliente_id])->with('status', 'Servizio elimnato correttamente!');
				}
			else
				{
				return redirect()->route('clienti-servizi-archiviati',['cliente_id' => $cliente_id])->with('status', 'Servizio elimnato correttamente!');
				}
			
 	   }
}
