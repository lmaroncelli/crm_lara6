<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RigheFatturazioneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    			$tblRigheFatturazione  =  DB::connection('old')
    			                ->table('righe_di_fatturazione')
    			                ->select(DB::raw('id, id_fattura as fattura_id, servizio, prezzo, qta, totale_netto, al_iva, iva, totale'))
    			                ->get();

    			$tblRigheFatturazione = collect($tblRigheFatturazione)->map(function($x){ return (array) $x; })->toArray(); 

    			DB::connection('mysql')->table('tblRigheFatturazione')->truncate();
    			
    			foreach ($tblRigheFatturazione as $riga) 
    				{
    		           DB::connection('mysql')->table('tblRigheFatturazione')->insert($riga);
    				}
    }
}
