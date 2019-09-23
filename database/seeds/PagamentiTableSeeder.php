<?php

use Illuminate\Database\Seeder;

class PagamentiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	$tblPagamenti  =  DB::connection('old')
        	                ->table('pagamenti')
        	                ->select(DB::raw('id as cod, cod_PA, nome'))
        	                ->get();

        	$tblPagamenti = collect($tblPagamenti)->map(function($x){ return (array) $x; })->toArray(); 

        	DB::connection('mysql')->table('tblPagamenti')->truncate();
        	
        	foreach ($tblPagamenti as $p) 
        		{
                   DB::connection('mysql')->table('tblPagamenti')->insert($p);
        		}
    }
}
