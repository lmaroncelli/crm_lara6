<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentroBenessereTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $centroBenessere  =  DB::connection('old')
            ->table('centroBenessere')
            ->select(DB::raw('id, foglio_id, sup_b, area_fitness, sup_fitness, aperto_dal_b, aperto_al_b, aperto_annuale_b, a_pagamento, in_hotel, distanza_hotel, eta_minima, obbligo_prenotazione, uso_esclusivo, piscina_benessere, idromassaggio, sauna_finlandese, bagno_turco, docce_emozionali, cascate_ghiaccio, aromaterapia, percorso_kneipp, cromoterapia, massaggi, trattamenti_estetici, area_relax, letto_marmo_riscaldato, stanza_sale, kit_benessere, peculiarita '))
            ->get();

        $centroBenessere = collect($centroBenessere)->map(function ($x) {
            return (array) $x;
        })->toArray();

        DB::connection('mysql')->table('tblCentroBenessere')->truncate();

        foreach ($centroBenessere as $info) {
            DB::connection('mysql')->table('tblCentroBenessere')->insert($info);
        }
    }
}
