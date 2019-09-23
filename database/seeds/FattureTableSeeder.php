<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FattureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		
	$tblFatture  =  DB::connection('old')
	                ->table('fatture')
	                ->select(DB::raw('id, id_tipo as tipo_id, numero_fattura, numero_prefattura, data, pagamenti_id as pagamento_id, note, totale, da_fatturare, societa_id, pagata'))
	                ->get();

	$tblFatture = collect($tblFatture)->map(function($x){ return (array) $x; })->toArray(); 

	DB::connection('mysql')->table('tblFatture')->truncate();
	
	foreach ($tblFatture as $fattura) 
		{
            $fattura['data'] = (is_null($fattura['data']) || $fattura['data'] == 0) ? null: Carbon::createFromTimestamp($fattura['data'])->toDateString();

           DB::connection('mysql')->table('tblFatture')->insert($fattura);
		}
    }
}
