<?php

namespace App\MyTrait;


use App\Fattura;
use Illuminate\Http\Request;
use PDF;


trait MyTrait
{



	public function getPdfFattura(Request $request, $fattura_id, $salva=NULL)
	  {
	  $fattura = Fattura::with([
	            'pagamento',
	            'righe',
	            'scadenze',
	            'societa.RagioneSociale.localita.comune.provincia',
	            'societa.cliente.servizi_non_fatturati',
	            'prefatture',
	          ])->find($fattura_id);
	  
	  //return view('fatture.fattura_pdf', compact('fattura'));
	  
	  $pdf = PDF::loadView('fatture.fattura_pdf', compact('fattura'));

	  if (is_null($salva)) 
	    {          
	    return $pdf->stream();
	    } 
	  else 
	    {
	    $num = str_replace(['/','\\'], '', $fattura->numero_fattura);        
	    $nome_file = $fattura->tipo_id . '_' .  $num;

	    $filepdf_path = storage_path('app/public/fatture').'/'.$nome_file.'.pdf';

	    $pdf->save($filepdf_path);

	    return $nome_file.'.pdf';
	    
	    }
	  
	  }

}