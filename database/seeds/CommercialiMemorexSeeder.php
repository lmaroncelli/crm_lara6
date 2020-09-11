<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommercialiMemorexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tblCommMemorex  =  DB::connection('old')
                       ->table('commerciali_memorex')
                       ->select(DB::raw("id, concat(nome,' ', cognome) as nome, email"))
                       ->get();

        $tblCommMemorex = collect($tblCommMemorex)->map(function($x){ return (array) $x; })->toArray(); 

    		DB::connection('mysql')->table('tblCommercialiMemorex')->truncate();

				foreach ($tblCommMemorex as $comm_memorex) 
					{
					DB::connection('mysql')->table('tblCommercialiMemorex')->insert($comm_memorex);
					}
    }
}
