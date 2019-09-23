<?php

use Illuminate\Database\Seeder;

class FatturePrefattureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	$tblFatturePrefatture  =  DB::connection('old')
        	                ->table('fatture_prefatture')
        	                ->select(DB::raw('id_fattura as fattura_id, id_prefattura as prefattura_id'))
        	                ->get();

        	$tblFatturePrefatture = collect($tblFatturePrefatture)->map(function($x){ return (array) $x; })->toArray(); 

        	DB::connection('mysql')->table('tblFatturePrefatture')->truncate();
        	
        	foreach ($tblFatturePrefatture as $fattura) 
        		{
              DB::connection('mysql')->table('tblFatturePrefatture')->insert($fattura);
        		}
    }
}
