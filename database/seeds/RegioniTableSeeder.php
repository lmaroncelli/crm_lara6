<?php

use Illuminate\Database\Seeder;

class RegioniTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$tblRegioni  =  DB::connection('old')
    	                ->table('regioni')
    	                ->select(DB::raw('idregione as id, nomeregione as nome'))
                        ->where('idregione','!=',0)
    	                ->get();

    	$tblRegioni = collect($tblRegioni)->map(function($x){ return (array) $x; })->toArray(); 

    	DB::connection('mysql')->table('tblRegioni')->truncate();
    	
    	foreach ($tblRegioni as $reg) 
    		{
    	  DB::connection('mysql')->table('tblRegioni')->insert($reg);
    		}
    }
}
