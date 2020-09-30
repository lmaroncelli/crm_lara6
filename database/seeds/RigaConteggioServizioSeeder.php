<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RigaConteggioServizioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tblserviziRigaConteggio  =  DB::connection('old')
    	                		->table('servizi_riga_conteggio')
    	                		->select(DB::raw('id_riga_conteggio as riga_conteggio_id, id_servizio as servizio_id, data_conteggio'))
    	                		->get();


    	$tblserviziRigaConteggio = collect($tblserviziRigaConteggio)->map(function($x){ return (array) $x; })->toArray(); 


    	DB::connection('mysql')->table('tblRigaConteggioServizio')->truncate();
    	

    	foreach ($tblserviziRigaConteggio as $src) 
    		{
				if ($src['data_conteggio'] != '0000-00-00 00:00:00') 
					{
					$src['updated_at'] = $src['data_conteggio'];
					$src['created_at'] = $src['data_conteggio'];
					}
				unset($src['data_conteggio']);
    	  DB::connection('mysql')->table('tblRigaConteggioServizio')->insert($src);
    		}
    }
}
