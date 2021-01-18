<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiziHotelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ServiziHotel  =  DB::connection('old')
            ->table('servizi_hotel')
            ->select(DB::raw('id, id_sorgente as sorgente_id, id_agente as user_id, id_cliente as cliente_id, data_creazione, nome_hotel, localita, sms, whatsapp, skype, prezzo_min ,prezzo_max, stagione, pti_anno_prec, pasti_anno_prec, numeri_anno_prec, pf_1, pf_2, pf_3, pf_4, pf_5, pf_6, pf_7, pf_8, pf_9, note_pf, dal, al, fiere ,pasqua, capodanno, aprile_25, maggio_1, altra_apertura, n_camere, n_app, n_suite, n_letti, h_24, rec_dalle_ore, rec_dalle_minuti, rec_alle_ore ,rec_alle_minuti, checkin, checkout, colazione_dalle_ore, colazione_dalle_minuti, colazione_alle_ore, colazione_alle_minuti ,pranzo_dalle_ore, pranzo_dalle_minuti, pranzo_alle_ore, pranzo_alle_minuti, cena_dalle_ore, cena_dalle_minuti, cena_alle_ore ,cena_alle_minuti, ai, note_ai, pc, note_pc, mp, note_mp, mp_spiaggia, note_mp_spiaggia, bb, note_bb, bb_spiaggia, note_bb_spiaggia, sd, note_sd ,sd_spiaggia, note_sd_spiaggia, caparra, altra_caparra, contanti, assegno, carta_credito, bonifico, paypal, bancomat, note_pagamenti, inglese ,francese, tedesco, spagnolo, russo, altra_lingua, tipo, apertura, categoria, piscina, benessere, disabili, organizzazione_matrimoni ,organizzazione_cresime, organizzazione_comunioni, note_organizzazione_matrimoni, nome_file, data_firma'))
            ->get();

        $ServiziHotel = collect($ServiziHotel)->map(function ($x) {
            return (array) $x;
        })->toArray();

        DB::connection('mysql')->table('tblServiziHotel')->truncate();

        foreach ($ServiziHotel as $servizio) {
            DB::connection('mysql')->table('tblServiziHotel')->insert($servizio);
        }
    }
}
