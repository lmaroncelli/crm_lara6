<?php

use Illuminate\Database\Seeder;

class EvidenzeMesiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	$tblEVEvidenzeMesi  =  DB::connection('old')
        	                ->table('ev_evidenze_mese')
        	                ->select(DB::raw('id, id_evidenza as evidenza_id, id_mese as mese_id, id_hotel as cliente_id, id_agente as user_id, acquistata, prelazionata, id_servizio_web as servizioweb_id, nome_hotel'))
        	                ->get();

        	$tblEVEvidenzeMesi = collect($tblEVEvidenzeMesi)->map(function($x){ return (array) $x; })->toArray(); 

        	DB::connection('mysql')->table('tblEVEvidenzeMesi')->truncate();
        	
        	foreach ($tblEVEvidenzeMesi as $evidenzamese) 
        		{
                DB::connection('mysql')->table('tblEVEvidenzeMesi')->insert($evidenzamese);
        		}
    }
}
