<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvvisiFattureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $tblAvvisiFatture  =  DB::connection('old')
				    	                ->table('avvisi_fatture')
				    	                ->select(DB::raw('id, tipo_pagamento, testo, email, giorni, id_fattura as fattura_id, data'))
				    	                ->get();

				$tblAvvisiFatture = collect($tblAvvisiFatture)->map(function($x){ return (array) $x; })->toArray(); 

				DB::connection('mysql')->table('tblAvvisiFatture')->truncate();


				foreach ($tblAvvisiFatture as $avviso) 
					{
					
					$avviso['data'] = (is_null($avviso['data']) || $avviso['data'] == 0) ? null : Carbon::createFromTimestamp($avviso['data'])->toDateTimeString();


					DB::connection('mysql')->table('tblAvvisiFatture')->insert($avviso);

					}

    }

}
