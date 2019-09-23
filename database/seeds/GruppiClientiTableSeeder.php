<?php

use Illuminate\Database\Seeder;

class GruppiClientiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
    	$tblGruppiClienti  =  DB::connection('old')
    	                ->table('gruppi_clienti')
    	                ->get();

    	$tblGruppiClienti = collect($tblGruppiClienti)->map(function($x){ return (array) $x; })->toArray(); 

    	DB::connection('mysql')->table('tblGruppiClienti')->truncate();
    	
    	foreach ($tblGruppiClienti as $gruppo) 
    		{
    	  DB::connection('mysql')->table('tblGruppiClienti')->insert($gruppo);
    		}

    }
}
