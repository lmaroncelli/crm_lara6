<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ServiziTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		$tblServizi  =  DB::connection('old')
    		                ->table('servizi')
    		                ->select(DB::raw('id, id_cliente as cliente_id, id_prodotto as prodotto_id, id_fattura as fattura_id, attivo, data_inizio, data_fine , note, note_commerciale, archiviato, da_pagare_reminder, archivia_alla_scadenza'))
    		                ->get();

    		$tblServizi = collect($tblServizi)->map(function($x){ return (array) $x; })->toArray(); 

    		DB::connection('mysql')->table('tblServizi')->truncate();
    		
    		foreach ($tblServizi as $servizio) 
    			{
                   $servizio['data_inizio'] = (is_null($servizio['data_inizio']) || $servizio['data_inizio'] == 0) ? null: Carbon::createFromTimestamp($servizio['data_inizio'])->toDateString();
    	           $servizio['data_fine'] = (is_null($servizio['data_fine']) || $servizio['data_fine'] == 0) ? null: Carbon::createFromTimestamp($servizio['data_fine'])->toDateString();

    	           DB::connection('mysql')->table('tblServizi')->insert($servizio);
    			}
    }
}
