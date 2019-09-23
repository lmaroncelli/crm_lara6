<?php

use Illuminate\Database\Seeder;

class LocalitaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
    		$tblLocalita  =  DB::connection('old')
    		                ->table('localita')
    		                ->select(DB::raw('id, nome, id_comune as comune_id, id_macrolocalita as macrolocalita_id'))
    	                  ->where('id','!=',0)
    		                ->get();

    		$tblLocalita = collect($tblLocalita)->map(function($x){ return (array) $x; })->toArray(); 

    		DB::connection('mysql')->table('tblLocalita')->truncate();
    		
    		foreach ($tblLocalita as $loc) 
    			{
    		  DB::connection('mysql')->table('tblLocalita')->insert($loc);
    			}
    
    }
}
