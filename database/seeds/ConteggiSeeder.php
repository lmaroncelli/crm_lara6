<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConteggiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			$tblConteggi  =  DB::connection('old')
			->table('conteggi')
			->select(DB::raw('id, titolo, id_commerciale as user_id, terminato, approvato'))
			->get();

			$tblConteggi = collect($tblConteggi)->map(function($x){ return (array) $x; })->toArray(); 

			DB::connection('mysql')->table('tblConteggi')->truncate();

			foreach ($tblConteggi as $conteggio) 
			{
			DB::connection('mysql')->table('tblConteggi')->insert($conteggio);
			}
    }
}
