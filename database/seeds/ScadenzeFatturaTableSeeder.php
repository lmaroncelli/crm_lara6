<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScadenzeFatturaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	$tblScadenzeFattura  =  DB::connection('old')
       	                ->table('scadenza_fattura')
       	                ->select(DB::raw('id, id_fattura as fattura_id, importo, data_scadenza, note, pagata'))
       	                ->get();

       	$tblScadenzeFattura = collect($tblScadenzeFattura)->map(function($x){ return (array) $x; })->toArray(); 

       	DB::connection('mysql')->table('tblScadenzeFattura')->truncate();
       	
       	foreach ($tblScadenzeFattura as $scadenza) 
       		{
                   $scadenza['data_scadenza'] = (is_null($scadenza['data_scadenza']) || $scadenza['data_scadenza'] == 0) ? null: Carbon::createFromTimestamp($scadenza['data_scadenza'])->toDateString();

                  DB::connection('mysql')->table('tblScadenzeFattura')->insert($scadenza);
       		}
    }
}
