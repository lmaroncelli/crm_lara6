<?php

use Illuminate\Database\Seeder;

class ProdottiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$tblProdotti  =  DB::connection('old')
    	                ->table('prodotti')
    	                ->select(DB::raw('id, nome'))
    	                ->where('deleted',0)
    	                ->get();

    	$tblProdotti = collect($tblProdotti)->map(function($x){ return (array) $x; })->toArray(); 

    	DB::connection('mysql')->table('tblProdotti')->truncate();
    	
    	foreach ($tblProdotti as $prodotto) 
    		{
    	  DB::connection('mysql')->table('tblProdotti')->insert($prodotto);
    		}
 
    }
}
