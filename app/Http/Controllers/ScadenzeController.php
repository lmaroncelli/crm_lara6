<?php

namespace App\Http\Controllers;

use App\ScadenzaFattura;
use Illuminate\Http\Request;

class ScadenzeController extends Controller
{
    public function index(Request $request)
     	{

     	$to_append = [];


      $orderby = $request->get('orderby');
      $order = $request->get('order');


   		$scadenze = ScadenzaFattura::
   									whereHas(
      							'fattura' , function($q) {
                     $q->where('tipo_id','!=','NC');
                   	})
   									->with(['fattura.pagamento','fattura.societa.cliente','fattura.societa.ragioneSociale','fattura.avvisi'])
   									->notPagata();



      if(is_null($order))
        {
          $order='asc';
        }

      if(is_null($orderby))
        {
          $orderby='data_scadenza';
        }


      if($orderby == 'data_scadenza' || $orderby == 'importo' || $orderby == 'giorni_rimasti')
        {
        $scadenze = $scadenze->orderBy($orderby,$order);
        }


   		$scadenze = $scadenze
                  ->paginate(50)->setpath('')->appends($to_append);

   		 return view('scadenze.index', compact('scadenze'));

      }
}
