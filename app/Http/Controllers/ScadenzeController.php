<?php

namespace App\Http\Controllers;

use App\ScadenzaFattura;
use Illuminate\Http\Request;

class ScadenzeController extends Controller
{
    public function index(Request $request)
     	{

     	$to_append = [];

   		$scadenze = ScadenzaFattura::
   									whereHas(
      							'fattura' , function($q) {
                     $q->where('tipo_id','!=','NC');
                   	})
   									->with(['fattura.pagamento','fattura.societa.cliente','fattura.societa.ragioneSociale'])
   									->notPagata();


   		$scadenze = $scadenze
                  ->paginate(15)->setpath('')->appends($to_append);

   		 return view('scadenze.index', compact('scadenze'));

      }
}
