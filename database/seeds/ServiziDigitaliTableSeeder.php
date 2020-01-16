<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiziDigitaliTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $ServiziDigitali  =  DB::connection('old')
       	                ->table('servizi_web')
       	                ->select(DB::raw('id,id_foglio_servizi as contratto_id,id_servizio_scontato as servizio_scontato_id,nome,localita,pagina,altro_servizio,dal,al,qta,importo,sconto,scontato'))
                         ->get();

      $ServiziDigitali = collect($ServiziDigitali)->map(function($x){ return (array) $x; })->toArray(); 

      DB::connection('mysql')->table('tblContrattiDigitali')->truncate();
      
      foreach ($ServiziDigitali as $servizio) 
        {
        DB::connection('mysql')->table('tblContrattiDigitali')->insert($servizio);
        }
    }
}


