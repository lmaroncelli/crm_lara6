<?php

use Illuminate\Database\Seeder;

class CategorieClientiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$tblCategorieClienti  =  DB::connection('old')
    	                ->table('categoria_hotel')
                        ->where('id', '!=',0)
    	                ->get();

    	$tblCategorieClienti = collect($tblCategorieClienti)->map(function($x){ return (array) $x; })->toArray(); 

    	DB::connection('mysql')->table('tblCategorieClienti')->truncate();
    	
    	foreach ($tblCategorieClienti as $categoria) 
    		{
    	  DB::connection('mysql')->table('tblCategorieClienti')->insert($categoria);
    		}
    }
}
