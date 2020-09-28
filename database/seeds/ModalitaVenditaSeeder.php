<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalitaVenditaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tblModalitaVendita  =  DB::connection('old')
        	                ->table('modalita_vendita')
        	                ->select(DB::raw('id, nome, deleted'))
        	                ->get();

        	$tblModalitaVendita = collect($tblModalitaVendita)->map(function($x){ return (array) $x; })->toArray(); 

        	DB::connection('mysql')->table('tblModalitaVendita')->truncate();
        	
        	foreach ($tblModalitaVendita as $m) 
        		{
                   DB::connection('mysql')->table('tblModalitaVendita')->insert($m);
        		}
    }
}
