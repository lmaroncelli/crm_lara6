<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvidenzeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	$tblEVEvidenze  =  DB::connection('old')
        	                ->table('ev_evidenza')
        	                ->select(DB::raw('id, id_tipo_evidenza as tipoevidenza_id'))
        	                ->get();

        	$tblEVEvidenze = collect($tblEVEvidenze)->map(function($x){ return (array) $x; })->toArray(); 

        	DB::connection('mysql')->table('tblEVEvidenze')->truncate();
        	
        	foreach ($tblEVEvidenze as $evidenza) 
        		{
                DB::connection('mysql')->table('tblEVEvidenze')->insert($evidenza);
        		}
    }
}
