<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElencoServiziHotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tblServiziFoglio  =  DB::connection('old')
            ->table('elenco_servizi_hotel')
            ->select(DB::raw('id, nome, id_gruppo as gruppo_id, id_info as info_id, `order`'))
            ->get();

        $tblServiziFoglio = collect($tblServiziFoglio)->map(function ($x) {
            return (array) $x;
        })->toArray();

        DB::connection('mysql')->table('tblServiziFoglio')->truncate();

        foreach ($tblServiziFoglio as $servizio) {
            DB::connection('mysql')->table('tblServiziFoglio')->insert($servizio);
        }
    }
}
