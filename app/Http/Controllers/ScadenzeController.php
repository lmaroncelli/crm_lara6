<?php

namespace App\Http\Controllers;

use App\Pagamento;
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


       $to_append = [
            'order' => $order, 
            'orderby' => $orderby 
            ];


      if($orderby == 'data_scadenza' || $orderby == 'importo')
        {
        $scadenze = $scadenze->orderBy($orderby,$order);
        }

      if($orderby == 'giorni_rimasti')
        {
        $scadenze = $scadenze->orderByRaw("to_days(date_format(`tblScadenzeFattura`.`data_scadenza`,'%Y-%m-%d')) - to_days(now()) $order");
        }


   		$scadenze = $scadenze
                  ->paginate(50)->setpath('')->appends($to_append);


      $pagamenti_fattura = Pagamento::whereNotNull('cod_PA')->where('cod','>',0)->get()->pluck('nome','id');


   		 return view('scadenze.index', compact('scadenze','pagamenti_fattura'));

      }
}
