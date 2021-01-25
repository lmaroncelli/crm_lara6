<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoglioAssociaServiziSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    // PRIMA CANCELLO LE RIGHE DELL'ASSOCIAZIONE CHE NON DOVREBBERO ESISTERE
    // SELECT ash.id_elenco, f.id_cliente 
    // from associazione_servizi_in_hotel ash LEFT JOIN fogli_servizi f ON ash.id_elenco = f.id
    //WHERE id_cliente IS NULL

    // DB::connection('old')
    // ->table('associazione_servizi_in_hotel')
    // ->leftjoin('fogli_servizi', 'associazione_servizi_in_hotel.id_elenco' ,'=', 'fogli_servizi.id')
    // ->whereNull('fogli_servizi.id_cliente')
    // ->delete();
    
    $tblServiziFoglio  =  DB::connection('old')
        ->table('associazione_servizi_in_hotel')
        ->select(DB::raw('id_servizio as servizio_id, id_elenco as foglio_id, note'))
        ->get();

    $tblServiziFoglio = collect($tblServiziFoglio)->map(function ($x) {
            return (array) $x;
        })->toArray();

    DB::connection('mysql')->table('tblFoglioAssociaServizi')->truncate();

    foreach ($tblServiziFoglio as $row) {
        DB::connection('mysql')->table('tblFoglioAssociaServizi')->insert($row);
    }
    }
}
