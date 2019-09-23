<?php

use Illuminate\Database\Seeder;

class ContattiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		$tblContatti  =  DB::connection('old')
    		                ->table('contatti')
    		                ->select(DB::raw('id, nome, email, cellulare, ruolo, note, fea_doc, fea_doc_name as fea_doc_nome'))
    		                ->get();

    		$tblContatti = collect($tblContatti)->map(function($x){ return (array) $x; })->toArray(); 

    		DB::connection('mysql')->table('tblContatti')->truncate();
    		
    		foreach ($tblContatti as $contatto) 
    			{
    		  DB::connection('mysql')->table('tblContatti')->insert($contatto);
    			}
    }
}
