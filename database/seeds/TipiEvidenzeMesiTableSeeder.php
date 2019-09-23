<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipiEvidenzeMesiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		$tblEVTipiEvidenzeMesi  =  DB::connection('old')
    		                ->table('ev_tipo_evidenza_mese')
    		                ->select(DB::raw('id, id_tipo_evidenza as tipoevidenza_id, id_mese as mese_id, costo'))
    		                ->get();

    		$tblEVTipiEvidenzeMesi = collect($tblEVTipiEvidenzeMesi)->map(function($x){ return (array) $x; })->toArray(); 

    		DB::connection('mysql')->table('tblEVTipiEvidenzeMesi')->truncate();
    		
    		foreach ($tblEVTipiEvidenzeMesi as $tipo_evidenza_mese) 
    			{
    	        DB::connection('mysql')->table('tblEVTipiEvidenzeMesi')->insert($tipo_evidenza_mese);
    			}
    }
}
