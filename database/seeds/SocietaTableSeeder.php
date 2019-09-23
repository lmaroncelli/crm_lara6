<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocietaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	$tblSocieta  =  DB::connection('old')
        	                ->table('societa')
        	                ->select(DB::raw('id, id_cliente as cliente_id, id_ragionesociale as ragionesociale_id, note,banca,abi,cab,iban'))
        	                ->get();

        	$tblSocieta = collect($tblSocieta)->map(function($x){ return (array) $x; })->toArray(); 

        	DB::connection('mysql')->table('tblSocieta')->truncate();
        	
        	foreach ($tblSocieta as $rag) 
        		{
                   DB::connection('mysql')->table('tblSocieta')->insert($rag);
        		}
    }
}
