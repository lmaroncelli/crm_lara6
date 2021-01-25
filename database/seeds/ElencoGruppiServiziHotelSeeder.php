<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElencoGruppiServiziHotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tblGruppoServiziHotel  =  DB::connection('old')
                            ->table('elenco_gruppi_servizi_hotel')
                            ->select(DB::raw('id, nome, id_info as info_id, `order`'))
                            ->get();

        $tblGruppoServiziHotel = collect($tblGruppoServiziHotel)->map(function ($x) {
            return (array) $x;
        })->toArray();

        DB::connection('mysql')->table('tblGruppiServiziFoglio')->truncate();

        foreach ($tblGruppoServiziHotel as $gruppo) {
            DB::connection('mysql')->table('tblGruppiServiziFoglio')->insert($gruppo);
        }

    }
}
