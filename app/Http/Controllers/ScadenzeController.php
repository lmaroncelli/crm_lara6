<?php

namespace App\Http\Controllers;

use App\User;
use App\Pagamento;
use Carbon\Carbon;
use App\ScadenzaFattura;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ScadenzeController extends Controller
{
    public function index(Request $request)
     	{

			//dd($request->all());
				
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

				$filter = 0;
			

			if( $request->has('commerciale_id') && $request->get('commerciale_id') !=0 )
      	{
				$to_append['commerciale_id'] = $request->get('commerciale_id');

				$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
					->whereHas(
					'fattura' , function($q) {
					$q->where('tipo_id','!=','NC');
					})
					->where('tblScadenzeFattura.pagata',0)
					->get();
				
				$scadenze_commerciale_ids = [];
				
				foreach ($scadenze as $scadenza) 
					{
					if(in_array( $request->get('commerciale_id'), $scadenza->fattura->societa->cliente->associato_a_commerciali->pluck('id')->toArray())) 
						{
							$scadenze_commerciale_ids[] = $scadenza->id;
						}
					}

				$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
					->whereHas(
					'fattura' , function($q) {
					$q->where('tipo_id','!=','NC');
					})
					->where('tblScadenzeFattura.pagata',0)
					->whereIn('tblScadenzeFattura.id',$scadenze_commerciale_ids);

				
				$filter = 1;
				}

      if( $request->has('pagamento') && $request->get('pagamento') !=0 )
      	{
				$to_append['pagamento'] = $request->get('pagamento');

				if(!$filter)
					{
					$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
						->whereHas(
						'fattura' , function($q) {
						$q->where('tipo_id','!=','NC');
						})
						->where('tblScadenzeFattura.pagata',0);
					
					$filter = 1;
					}
	
				$scadenze = $scadenze
					->join('tblFatture','tblScadenzeFattura.fattura_id', '=', 'tblFatture.id')
					->join('tblPagamenti', 'tblFatture.pagamento_id', '=', 'tblPagamenti.cod')
					->where('tblPagamenti.id',$request->get('pagamento'));
				
				
				}


			if ( $request->has('scadenza_dal') && $request->get('scadenza_dal') !=0 ) 
				{
				$to_append['scadenza_dal'] = $request->get('scadenza_dal');

					if (!$filter) 
						{
						$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
						->whereHas(
						'fattura' , function($q) {
						$q->where('tipo_id','!=','NC');
						})
						->notPagata()
						->where('data_scadenza', '>=', Carbon::createFromFormat('d/m/Y',$request->get('scadenza_dal'))->toDateString());  
						
						$filter = 1;
						
						} 
					else 
						{
						$scadenze = $scadenze->where('data_scadenza', '>=', Carbon::createFromFormat('d/m/Y',$request->get('scadenza_dal'))->toDateString());
						}

				} 


				if ( $request->has('scadenza_al') && $request->get('scadenza_al') !=0 ) 
					{
					$to_append['scadenza_al'] = $request->get('scadenza_al');

					if (!$filter) 
						{
						$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
						->whereHas(
						'fattura' , function($q) {
						$q->where('tipo_id','!=','NC');
						})
						->notPagata()
						->where('data_scadenza', '<=', Carbon::createFromFormat('d/m/Y',$request->get('scadenza_al'))->toDateString());  

						$filter = 1;
						} 
					else 
						{
						$scadenze = $scadenze->where('data_scadenza', '<=', Carbon::createFromFormat('d/m/Y',$request->get('scadenza_al'))->toDateString());
						}

					} 
			
				

				if(!$filter)
					{

					$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
								->whereHas(
								'fattura' , function($q) {
								$q->where('tipo_id','!=','NC');
								})
								->where('tblScadenzeFattura.pagata',0);  

					if ($orderby == 'tipo_pagamento') 
						{					
					
						$scadenze = $scadenze
									->join('tblFatture','tblScadenzeFattura.fattura_id', '=', 'tblFatture.id')
									->join('tblPagamenti', 'tblFatture.pagamento_id', '=', 'tblPagamenti.cod');

								
						
						$scadenze = $scadenze->orderBy('tblPagamenti.nome',$order);
						}  
					
					
					$filter = 1;
					
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
				
				$commerciali = User::commerciale()->get()->pluck('name','id');
					



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

				return view('scadenze.index', compact('scadenze','pagamenti_fattura','date','commerciali'));

      }

}
