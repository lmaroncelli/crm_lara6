<?php

use Illuminate\Database\Seeder;

class MacroLocalitaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    			$tblMacroLocalita  =  DB::connection('old')
    			                ->table('macrolocalita')
    		                  ->where('id','!=',0)
    			                ->get();

    			$tblMacroLocalita = collect($tblMacroLocalita)->map(function($x){ return (array) $x; })->toArray(); 

    			DB::connection('mysql')->table('tblMacroLocalita')->truncate();
    			
    			foreach ($tblMacroLocalita as $macro) 
    				{
    			  DB::connection('mysql')->table('tblMacroLocalita')->insert($macro);
    				}
    }
}
