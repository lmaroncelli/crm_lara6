<?php

namespace App\Http\Controllers;

use App\User;
use App\Utility;
use App\Pagamento;
use App\AvvisiFattura;
use Carbon\Carbon;
use App\ScadenzaFattura;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AvvisoPagamento;
use App\MyTrait\MyTrait;


class ScadenzeController extends Controller
{

		use MyTrait;

		
		public function __construct()
			{
			$this->middleware('forbiddenIfType:C');
			}

		public function incassate(Request $request) {

			return $this->index($request, 1);

		}



		public function switchScadenzaAjax(Request $request) {
			$scadenza_id = $request->scadenza_id;
			$pagata = $request->pagata;

			$s = ScadenzaFattura::find($scadenza_id);
			$s->pagata = $pagata;
			$s->save();

			return "ok";

		}

    public function index(Request $request, $pagata = 0)
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

				$filter = 0;


			//////////////////////////////////////
			// Ricerca campo libero del cliente //
			//////////////////////////////////////

			// se ho inserito un valore da cercare ed ho selzionato un campo
			// campo libero
      $qf = $request->get('qf');
      $field = $request->get('field');

			if (!is_null($qf) && $field != '0') {

				if ($field == 'numero_fattura') {
						
						$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
							->whereHas(
								'fattura',
								function ($q) use ($field, $qf){
									$q->where('tipo_id', '!=', 'NC')->where($field, $qf);
								}
							)
							->where('tblScadenzeFattura.pagata', $pagata);

				} elseif ($field == 'cliente_nome') {

							$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
							->whereHas(
								'fattura',
								function ($q) {
									$q->where('tipo_id', '!=', 'NC');
								}
							)
							->where('tblScadenzeFattura.pagata', $pagata);

							$scadenze = $scadenze
									->join('tblFatture', 'tblScadenzeFattura.fattura_id', '=', 'tblFatture.id')
									->join('tblSocieta', 'tblFatture.societa_id', '=', 'tblSocieta.id')
									->join('tblClienti', 'tblSocieta.cliente_id', '=', 'tblClienti.id')
									->where('tblClienti.nome','LIKE', '%'.$qf.'%');
			
				} elseif ($field == 'importo') {

						$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
							->whereHas(
								'fattura',
								function ($q) {
									$q->where('tipo_id', '!=', 'NC');
								}
							)
							->where('tblScadenzeFattura.pagata', $pagata)
							->where('tblScadenzeFattura.importo', $qf);
				
				} elseif ($field == 'note') {

						$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
							->whereHas(
								'fattura',
								function ($q) {
									$q->where('tipo_id', '!=', 'NC');
								}
							)
							->where('tblScadenzeFattura.pagata', $pagata)
							->where('tblScadenzeFattura.note', 'LIKE', '%' . $qf . '%');

				}


				$filter = 1;
			}
			

			if( $request->has('commerciale_id') && $request->get('commerciale_id') !=0 )
      	{
				$to_append['commerciale_id'] = $request->get('commerciale_id');

				if (!$filter) {
						$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
							->whereHas(
							'fattura' , function($q) {
							$q->where('tipo_id','!=','NC');
							})
							->where('tblScadenzeFattura.pagata', $pagata);
				}
				
				$scadenze_commerciale_ids = [];
				
				foreach ($scadenze->get() as $scadenza) 
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
					->where('tblScadenzeFattura.pagata', $pagata)
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
						->where('tblScadenzeFattura.pagata', $pagata);
					
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
						->where('tblScadenzeFattura.pagata', $pagata)
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
					->where('tblScadenzeFattura.pagata', $pagata)
					->where('data_scadenza', '<=', Carbon::createFromFormat('d/m/Y',$request->get('scadenza_al'))->toDateString());  

					$filter = 1;
					} 
				else 
					{
					$scadenze = $scadenze->where('data_scadenza', '<=', Carbon::createFromFormat('d/m/Y',$request->get('scadenza_al'))->toDateString());
					}

				} 
			
				

			if(!$filter && !$pagata)
				{

				$scadenze = ScadenzaFattura::getScadenzeEagerLoaded()
							->whereHas(
							'fattura' , function($q) {
							$q->where('tipo_id','!=','NC');
							})
							->where('tblScadenzeFattura.pagata', $pagata);  

				if ($orderby == 'tipo_pagamento') 
					{					
				
					$scadenze = $scadenze
								->join('tblFatture','tblScadenzeFattura.fattura_id', '=', 'tblFatture.id')
								->join('tblPagamenti', 'tblFatture.pagamento_id', '=', 'tblPagamenti.cod');

							
					
					$scadenze = $scadenze->orderBy('tblPagamenti.nome',$order);
					}  
				
				
				$filter = 1;
				
				}


			
			if (isset($scadenze)) {

				if($orderby == 'data_scadenza' || $orderby == 'importo')
					{
					$scadenze = $scadenze->orderBy($orderby,$order);
					}
	
				if($orderby == 'giorni_rimasti')
					{
					$scadenze = $scadenze->orderByRaw("to_days(date_format(`tblScadenzeFattura`.`data_scadenza`,'%Y-%m-%d')) - to_days(now()) $order");
					}
	
	
				$scadenze_csv = $scadenze;
	
				$scadenze_csv = $scadenze_csv->get();
	
				// metto la query in sessione per utilizzarla nella creazione del CSV
				$request->session()->put('scadenze_csv', $scadenze_csv); 
	
				$scadenze = $scadenze
										->paginate(50)->setpath('')->appends($to_append);
			
			} else {

				$scadenze = null;
			
			}



			$pagamenti_fattura = Pagamento::whereNotNull('cod_PA')->where('cod','>',0)->get()->pluck('nome','id');
			
			$commerciali = User::commerciale()->get()->pluck('name','id');
					



			$scadenze_for_dates = ScadenzaFattura::with(['fattura.pagamento','fattura.societa.cliente','fattura.societa.ragioneSociale','fattura.avvisi'])
											->whereHas(
											'fattura' , function($q) {
											$q->where('tipo_id','!=','NC');
											})
											->where('tblScadenzeFattura.pagata', $pagata)
											->orderBy('data_scadenza','desc');

			// in questo modo ho preso le date distinte
			// 2020-12-31 00:00:00
			$collection = $scadenze_for_dates->pluck('id','data_scadenza')->toArray();


			$date = [];   

			foreach ($collection as $data_s => $value) 
				{        
				$date[] =  Carbon::createFromFormat('Y-m-d',$data_s)->format('d/m/Y');
				}

			
	
			return view('scadenze.index', compact('scadenze','pagamenti_fattura','date','commerciali', 'pagata'));

			}
			

			public function sendMailAvvisoPagamentoAjax(Request $request)
				{
				
				try 
					{
						$scadenza_id = $request->get('scadenza_id');

						$scadenza = ScadenzaFattura::with(['fattura.societa',
																								'fattura.pagamento'
																							])->find($scadenza_id); 
						
						$fattura = optional($scadenza)->fattura;
						
						if(!is_null($fattura))
							{

							$cliente = optional($fattura->societa)->cliente;
							$tipo_pagamento = optional($fattura->pagamento)->nome;
							if(!is_null($cliente))
								{
								$cliente->email_amministrativa != '' ? $mail_to = $cliente->email_amministrativa : $mail_to = $cliente->email;

								// salva il pdf in storage_path('app/public/fatture') e restituisce il nome_file.pdf
				    		$file_pdf =  $this->getPdfFattura($request, $fattura->id, $salva=1);
								
				    		$scadenza->giorni_rimasti <= 0 ? $tipo_mail = "scaduto" : $tipo_mail = "in scadenza"; // check gg_rimasti

				    		Mail::to($mail_to)->send(new AvvisoPagamento($tipo_mail, $tipo_pagamento, $file_pdf));

				    		AvvisiFattura::create([
				    			'tipo_pagamento' => $tipo_mail,
				    			'email' => $mail_to,
				    			'giorni' => $scadenza->giorni_rimasti,
				    			'data' => Carbon::now()->format('Y-m-d H:m:s'),
				    			'fattura_id' =>  $fattura->id
				    		]);

				    		echo 'Messaggio inviato correttamente';
								}

							}
					} 
				catch (\Exception $e) 
					{
					echo $e->getMessage();
					}
				

				}

		
			public function  export_csv(Request $request) 
			{
			if($request->session()->has('scadenze_csv'))
				{
					$scadenze_csv = $request->session()->get('scadenze_csv');

					$fileName = 'scadenze.csv';

					$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
				);
				
				$columns = array('N. Fattura', 'Scadenza', 'ID', 'Cliente', 'Importo', 'GG. Rimanenti', 'Pagamento', 'Commerciale', 'Note');

				$callback = function() use($scadenze_csv, $columns) {
					$file = fopen('php://output', 'w');
					fputcsv($file, $columns);

					foreach ($scadenze_csv as $s) 
						{
						$row[$columns[0]]  = optional( $s->fattura )->numero_fattura;
						
						$row[$columns[1]]  = optional( $s->data_scadenza )->format('d/m/Y');
						
						$row[$columns[2]]  = optional(optional(optional($s->fattura)->societa)->cliente)->id_info;
					
						$row[$columns[3]]  = optional(optional(optional($s->fattura)->societa)->cliente)->nome;


						$row[$columns[4]]  = Utility::formatta_cifra($s->importo);
					
						$row[$columns[5]]  = $s->giorni_rimasti;

						$row[$columns[6]]  = optional(optional($s->fattura)->pagamento)->nome;

						$row[$columns[7]]  = optional(optional(optional($s->fattura)->societa)->cliente)->commerciali();

						$row[$columns[8]]  = $s->note;


						fputcsv( $file, [ $row[$columns[0]], $row[$columns[1]], $row[$columns[2]], $row[$columns[3]], $row[$columns[4]], $row[$columns[5]], $row[$columns[6]], $row[$columns[7]], $row[$columns[8]] ] );
						}

					fclose($file);
				};

				return response()->stream($callback, 200, $headers);

				}
			}

}
