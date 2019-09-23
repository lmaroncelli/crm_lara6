<?php

use Illuminate\Database\Seeder;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$tblProvince  =  DB::connection('old')
    	                ->table('province')
    	                ->select(DB::raw('idprovincia as id, nomeprovincia as nome, siglaprovincia as sigla, idregione as regione_id'))
                        ->where('idprovincia','!=',0)
    	                ->get();

    	$tblProvince = collect($tblProvince)->map(function($x){ return (array) $x; })->toArray(); 

    	DB::connection('mysql')->table('tblProvince')->truncate();
    	
    	foreach ($tblProvince as $prov) 
    		{
    	  DB::connection('mysql')->table('tblProvince')->insert($prov);
    		}
    }
}
