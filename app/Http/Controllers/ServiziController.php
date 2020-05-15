<?php

namespace App\Http\Controllers;

use App\Servizio;
use Illuminate\Http\Request;

class ServiziController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
      {

      // campo libero
      $qf = $request->get('qf');
      $field = $request->get('field');

      $orderby = $request->get('orderby');
      $order = $request->get('order');

       $servizi = Servizio::
      						whereHas(
      							'cliente' , function($q) {
                     $q->where('attivo',1);
                   	})
      						->with(['cliente.localita','prodotto','fattura'])
      						->notArchiviato();



      if(is_null($order))
        {
          $order='asc';
        }

      if(is_null($orderby))
        {
          $orderby='id';
        }
      
      $to_append = ['order' => $order, 'orderby' => $orderby];


      if ($orderby == 'nome_cliente') 
        {
        	$servizi = $servizi
                ->select('tblServizi.*')
                ->join('tblClienti', 'tblServizi.cliente_id', '=', 'tblClienti.id');

          $servizi = $servizi
                    ->orderBy('tblClienti.nome', $order);
        }


       $servizi = $servizi
                  ->paginate(15)->setpath('')->appends($to_append);


      return view('servizi.index', compact('servizi'));
      }
}
