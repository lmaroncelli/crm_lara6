<?php

use Illuminate\Database\Seeder;

class TipologieClientiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		$tblTipologieClienti  =  DB::connection('old')
    		                ->table('tipologia_clienti')
    		                ->get();

    		$tblTipologieClienti = collect($tblTipologieClienti)->map(function($x){ return (array) $x; })->toArray(); 

    		DB::connection('mysql')->table('tblTipologieClienti')->truncate();
    		
    		foreach ($tblTipologieClienti as $tipo) 
    			{
    		  DB::connection('mysql')->table('tblTipologieClienti')->insert($tipo);
    			}
    }
}
