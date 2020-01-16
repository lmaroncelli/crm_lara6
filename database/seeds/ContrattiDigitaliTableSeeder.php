<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContrattiDigitaliTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $FogliServizi  =  DB::connection('old')
       	                ->table('fogli_servizi')
       	                ->select(DB::raw('id,id_agente as user_id,id_cliente as cliente_id ,dati_cliente,data_creazione,tipo_contratto,altro_tipo_contratto,dati_fatturazione,dati_referente,iban,iban_importato,pec,codice_destinatario,condizioni_pagamento,data_pagamento,note,sito_web,email,email_amministrativa,nome_file'))
                         ->get();
                         
      $FogliServizi = collect($FogliServizi)->map(function($x){ return (array) $x; })->toArray(); 

      DB::connection('mysql')->table('tblContrattiDigitali')->truncate();
      
      foreach ($FogliServizi as $contratto) 
        {
        DB::connection('mysql')->table('tblContrattiDigitali')->insert($contratto);
        }
    }
    
}


