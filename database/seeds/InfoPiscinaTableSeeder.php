<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoPiscinaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $InfoPiscina  =  DB::connection('old')
            ->table('infoPiscina')
            ->select(DB::raw('id, folgio_id as foglio_id, sup, h, h_min, h_max, aperto_dal, aperto_al, aperto_annuale, espo_sole, espo_sole_tutto_giorno, posizione, coperta, riscaldata, salata, idro, idro_cervicale, scivoli, trampolino, aperitivi, getto_bolle, cascata, musica_sub, wi_fi, pagamento, vasca_posizione, salvataggio, nuoto_contro, peculiarita_piscina, lettini_dispo, vasca_bimbi_h, vasca_bimbi_sup, vasca_idro_posti_dispo, vasca_idro_riscaldata, vasca_pagamento, vasca_idro_n_dispo, vasca_bimbi_riscaldata'))
            ->get();

        $InfoPiscina = collect($InfoPiscina)->map(function ($x) {
            return (array) $x;
        })->toArray();

        DB::connection('mysql')->table('tblInfoPiscina')->truncate();

        foreach ($InfoPiscina as $info) {
            DB::connection('mysql')->table('tblInfoPiscina')->insert($info);
        }
    }
}
