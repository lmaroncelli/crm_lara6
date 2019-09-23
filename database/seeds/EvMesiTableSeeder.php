<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvMesiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	$tblEVMesi  =  DB::connection('old')
        	                ->table('ev_mese')
        	                ->get();

        	$tblEVMesi = collect($tblEVMesi)->map(function($x){ return (array) $x; })->toArray(); 

        	DB::connection('mysql')->table('tblEVMesi')->truncate();
        	
        	foreach ($tblEVMesi as $mese) 
        		{
        	  DB::connection('mysql')->table('tblEVMesi')->insert($mese);
        		}
    }
}
