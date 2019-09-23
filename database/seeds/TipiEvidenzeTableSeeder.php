<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipiEvidenzeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		$tblEVTipiEvidenze  =  DB::connection('old')
    		                ->table('ev_tipo_evidenza')
    		                ->select(DB::raw('id, id_macro as macrolocalita_id, nome,n_max_visibile,n_min_mesi,ordine,macrotipologia'))
    		                ->get();

    		$tblEVTipiEvidenze = collect($tblEVTipiEvidenze)->map(function($x){ return (array) $x; })->toArray(); 

    		DB::connection('mysql')->table('tblEVTipiEvidenze')->truncate();
    		
    		foreach ($tblEVTipiEvidenze as $tipo_evidenza) 
    			{
    	        DB::connection('mysql')->table('tblEVTipiEvidenze')->insert($tipo_evidenza);
    			}
    	    
    }
}
