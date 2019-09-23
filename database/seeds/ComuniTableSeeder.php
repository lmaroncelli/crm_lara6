<?php

use Illuminate\Database\Seeder;

class ComuniTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$tblComuni  =  DB::connection('old')
    	                ->table('comuni')
    	                ->select(DB::raw('idcomune as id, nomecomune as nome, idprovincia as provincia_id'))
                        ->where('idcomune','!=',0)
    	                ->get();

    	$tblComuni = collect($tblComuni)->map(function($x){ return (array) $x; })->toArray(); 

    	DB::connection('mysql')->table('tblComuni')->truncate();
    	
    	foreach ($tblComuni as $comune) 
    		{
    	  DB::connection('mysql')->table('tblComuni')->insert($comune);
    		}
    }
}
