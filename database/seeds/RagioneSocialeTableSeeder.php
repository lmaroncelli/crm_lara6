<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RagioneSocialeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		$tblRagioneSociale  =  DB::connection('old')
    		                ->table('ragionesociale')
    		                ->select(DB::raw('id, nome, id_localita as localita_id, cap, indirizzo, piva, cf, pec, codice_sdi, note'))
                            ->where('id','!=',0)
    		                ->get();

    		$tblRagioneSociale = collect($tblRagioneSociale)->map(function($x){ return (array) $x; })->toArray(); 

    		DB::connection('mysql')->table('tblRagioneSociale')->truncate();
    		
    		foreach ($tblRagioneSociale as $rag) 
    			{
    	           DB::connection('mysql')->table('tblRagioneSociale')->insert($rag);
    			}
    }
}
