<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommercialeModalitaVenditaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tblModalitaVendita  =  DB::connection('old')
                    ->table('modalita_vendita_commerciale')
                    ->select(DB::raw('id_mod_vendita as modalita_id, id_commerciale as user_id, percentuale'))
                    ->get();

        $tblModalitaVendita = collect($tblModalitaVendita)->map(function($x){ return (array) $x; })->toArray(); 

        DB::connection('mysql')->table('tblCommercialeModalitaVendita')->truncate();

        foreach ($tblModalitaVendita as $mod) 
        {
        DB::connection('mysql')->table('tblCommercialeModalitaVendita')->insert($mod);
        }


    }
}
