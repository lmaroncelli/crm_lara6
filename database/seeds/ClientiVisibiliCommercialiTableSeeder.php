<?php

use Illuminate\Database\Seeder;

class ClientiVisibiliCommercialiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	$tblMembershipClienti  =  DB::connection('old')
    	                		->table('membership_clienti')
    	                		->select(DB::raw('id_utente as user_id, id_cliente as cliente_id'))
    	                		->get();


    	$tblMembershipClienti = collect($tblMembershipClienti)->map(function($x){ return (array) $x; })->toArray(); 


    	DB::connection('mysql')->table('tblClienteVisibileCommerciale')->truncate();
    	

    	foreach ($tblMembershipClienti as $mc) 
    		{
    	  DB::connection('mysql')->table('tblClienteVisibileCommerciale')->insert($mc);
    		}


    }
}
