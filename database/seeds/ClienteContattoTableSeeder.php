<?php

use Illuminate\Database\Seeder;

class ClienteContattoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$tblClienteContatto  =  DB::connection('old')
    	                		->table('hotel_contatti')
    	                		->select(DB::raw('id_hotel as cliente_id, id_contatto as contatto_id'))
    	                		->get();


    	$tblClienteContatto = collect($tblClienteContatto)->map(function($x){ return (array) $x; })->toArray(); 


    	DB::connection('mysql')->table('tblClienteContatto')->truncate();
    	

    	foreach ($tblClienteContatto as $cc) 
    		{
    	  DB::connection('mysql')->table('tblClienteContatto')->insert($cc);
    		}
    }
}
