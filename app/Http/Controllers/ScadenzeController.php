<?php

namespace App\Http\Controllers;

use App\Pagamento;
use App\ScadenzaFattura;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScadenzeController extends Controller
{
    public function index(Request $request)
     	{
		
     	$to_append = [];


      $orderby = $request->get('orderby');
      $order = $request->get('order');


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


			$join_pagamento = 0;

      if( $request->has('pagamento') && $request->get('pagamento') !=0 )
      	{
				$scadenze = ScadenzaFattura::
					whereHas(
					'fattura' , function($q) {
					$q->where('tipo_id','!=','NC');
					})
					->with(['fattura.pagamento','fattura.societa.cliente','fattura.societa.ragioneSociale','fattura.avvisi'])
					->where('tblScadenzeFattura.pagata',0);  
	
				$scadenze = $scadenze
					->join('tblFatture','tblScadenzeFattura.fattura_id', '=', 'tblFatture.id')
					->join('tblPagamenti', 'tblFatture.pagamento_id', '=', 'tblPagamenti.cod')
					->where('tblPagamenti.id',$request->get('pagamento'));

				$join_pagamento = 1;
				}

      
      if ($orderby == 'tipo_pagamento') 
        {

					if(!$join_pagamento)
						{
						$scadenze = ScadenzaFattura::
									whereHas(
									'fattura' , function($q) {
									$q->where('tipo_id','!=','NC');
									})
									->with(['fattura.pagamento','fattura.societa.cliente','fattura.societa.ragioneSociale','fattura.avvisi'])
									->where('tblScadenzeFattura.pagata',0);  
					
						$scadenze = $scadenze
									->join('tblFatture','tblScadenzeFattura.fattura_id', '=', 'tblFatture.id')
									->join('tblPagamenti', 'tblFatture.pagamento_id', '=', 'tblPagamenti.cod');

						}
								
				
          $scadenze = $scadenze->orderBy('tblPagamenti.nome',$order);
        }  
      else 
        {
        $scadenze = ScadenzaFattura::
                whereHas(
                'fattura' , function($q) {
                $q->where('tipo_id','!=','NC');
                })
                ->with(['fattura.pagamento','fattura.societa.cliente','fattura.societa.ragioneSociale','fattura.avvisi'])
                ->notPagata();  
        }




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
        



      $scadenze_for_dates = ScadenzaFattura::
                    whereHas(
                    'fattura' , function($q) {
                     $q->where('tipo_id','!=','NC');
                    })
                    ->with(['fattura.pagamento','fattura.societa.cliente','fattura.societa.ragioneSociale','fattura.avvisi'])
                    ->notPagata()
                    ->orderBy('data_scadenza','desc');

      // in questo modo ho preso le date distinte
      // 2020-12-31 00:00:00
      $collection = $scadenze_for_dates->get()->pluck('id','data_scadenza')->toArray();

      //dd($collection);

      $date = [];   

      foreach ($collection as $data_s => $value) 
        {        
        $date[] =  Carbon::createFromFormat('Y-m-d H:i:s',$data_s)->format('d/m/Y');
        }

   		 return view('scadenze.index', compact('scadenze','pagamenti_fattura','date'));

      }

}
