<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScadenzeMemorexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$swap_categoria[1] = 'Info Alberghi';
    	$swap_categoria[2] = 'Info Alberghi';
    	$swap_categoria[3] = 'Milanomarittima.it';
    	$swap_categoria[4] = 'Hotel Manager';

			$swap_priorita[1] = 'Normale';
    	$swap_priorita[2] = 'Media';
    	$swap_priorita[3] = 'Alta';
    	$swap_priorita[4] = 'Amministrazione';    	

      $tblMemorex  =  DB::connection('old')
                       ->table('scadenze_memorex')
                       ->select(DB::raw('id, id_commerciale as user_id, id_categoria as categoria, titolo, descrizione, giorno, mese, anno, minuti, ore,  data, priorita, completato, data_disattivazione'))
                       ->get();

       	$tblMemorex = collect($tblMemorex)->map(function($x){ return (array) $x; })->toArray(); 

    		DB::connection('mysql')->table('tblScadenzeMemorex')->truncate();

				foreach ($tblMemorex as $memorex) 
					{
					 $memorex['categoria'] = $swap_categoria[$memorex['categoria']];

		       $memorex['data'] = (is_null($memorex['data']) || $memorex['data'] == 0) ? null: Carbon::createFromTimestamp($memorex['data'])->toDateString();

					 $memorex['priorita'] = $swap_priorita[$memorex['priorita']];


			     $memorex['data_disattivazione'] = (is_null($memorex['data_disattivazione']) || $memorex['data_disattivazione'] == 0) ? null: Carbon::createFromTimestamp($memorex['data_disattivazione'])->toDateString();



			      DB::connection('mysql')->table('tblScadenzeMemorex')->insert($memorex);
					}
   
    }
}
