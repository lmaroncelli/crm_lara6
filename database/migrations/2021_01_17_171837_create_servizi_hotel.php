<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiziHotel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblServiziHotel', function (Blueprint $table) {
            $table->id();
            $table->integer('sorgente_id')->default(0);
            $table->integer('user_id')->unsigned();
            $table->integer('cliente_id');
            $table->datetime('data_creazione')->nullable()->default(null);
            $table->string('nome_hotel')->nullable()->default(null);
            $table->string('localita')->nullable()->default(null);
            $table->string('sms')->nullable()->default(null);
            $table->string('whatsapp')->nullable()->default(null);
            $table->string('skype')->nullable()->default(null);
            $table->decimal('prezzo_min', 10, 2)->default(0.00);
            $table->decimal('prezzo_max', 10, 2)->default(0.00);
            $table->string('stagione')->nullable()->default(null);
            $table->boolean('pti_anno_prec')->nullable()->default(false);
            $table->boolean('pasti_anno_prec')->nullable()->default(false);
            $table->boolean('numeri_anno_prec')->nullable()->default(false);
            $table->string('pf_1')->nullable()->default(null);
            $table->string('pf_2')->nullable()->default(null);
            $table->string('pf_3')->nullable()->default(null);
            $table->string('pf_4')->nullable()->default(null);
            $table->string('pf_5')->nullable()->default(null);
            $table->string('pf_6')->nullable()->default(null);
            $table->string('pf_7')->nullable()->default(null);
            $table->string('pf_8')->nullable()->default(null);
            $table->string('pf_9')->nullable()->default(null);
            $table->text('note_pf')->nullable();
            $table->date('dal')->nullable()->default(null);
            $table->date('al')->nullable()->default(null);
            $table->boolean('fiere')->nullable()->default(false);
            $table->boolean('pasqua')->nullable()->default(false);
            $table->boolean('capodanno')->nullable()->default(false);
            $table->boolean('aprile_25')->nullable()->default(false);
            $table->boolean('maggio_1')->nullable()->default(false);
            $table->string('altra_apertura')->nullable()->default(null);
            $table->integer('n_camere');
            $table->integer('n_app');
            $table->integer('n_suite');
            $table->integer('n_letti');
            $table->boolean('h_24')->nullable()->default(false);
            $table->string('rec_dalle_ore', 2)->nullable()->default(null);
            $table->string('rec_dalle_minuti', 2)->nullable()->default(null);
            $table->string('rec_alle_ore', 2)->nullable()->default(null);
            $table->string('rec_alle_minuti', 2)->nullable()->default(null);
            $table->string('checkin')->nullable()->default(null);
            $table->string('checkout')->nullable()->default(null);

            $table->string('colazione_dalle_ore', 2)->nullable()->default(null);
            $table->string('colazione_dalle_minuti', 2)->nullable()->default(null);
            $table->string('colazione_alle_ore', 2)->nullable()->default(null);
            $table->string('colazione_alle_minuti', 2)->nullable()->default(null);

            $table->string('pranzo_dalle_ore', 2)->nullable()->default(null);
            $table->string('pranzo_dalle_minuti', 2)->nullable()->default(null);
            $table->string('pranzo_alle_ore', 2)->nullable()->default(null);
            $table->string('pranzo_alle_minuti', 2)->nullable()->default(null);

            $table->string('cena_dalle_ore', 2)->nullable()->default(null);
            $table->string('cena_dalle_minuti', 2)->nullable()->default(null);
            $table->string('cena_alle_ore', 2)->nullable()->default(null);
            $table->string('cena_alle_minuti', 2)->nullable()->default(null);

            $table->boolean('ai')->nullable()->default(false);
            $table->text('note_ai')->nullable();
            $table->boolean('pc')->nullable()->default(false);
            $table->text('note_pc')->nullable();

            $table->boolean('mp')->nullable()->default(false);
            $table->text('note_mp')->nullable();

            $table->boolean('mp_spiaggia')->nullable()->default(false);
            $table->text('note_mp_spiaggia')->nullable();

            $table->boolean('bb')->nullable()->default(false);
            $table->text('note_bb')->nullable();

            $table->boolean('bb_spiaggia')->nullable()->default(false);
            $table->text('note_bb_spiaggia')->nullable();
            
            $table->boolean('sd')->nullable()->default(false);
            $table->text('note_sd')->nullable();

            $table->boolean('sd_spiaggia')->nullable()->default(false);
            $table->text('note_sd_spiaggia')->nullable();

            $table->string('caparra', 2)->nullable()->default(null);
            $table->string('altra_caparra')->nullable()->default(null);

            $table->boolean('contanti')->nullable()->default(false);
            $table->boolean('assegno')->nullable()->default(false);
            $table->boolean('carta_credito')->nullable()->default(false);
            $table->boolean('bonifico')->nullable()->default(false);
            $table->boolean('paypal')->nullable()->default(false);
            $table->boolean('bancomat')->nullable()->default(false);
            $table->text('note_pagamenti')->nullable();

            $table->boolean('inglese')->nullable()->default(false);
            $table->boolean('francese')->nullable()->default(false);
            $table->boolean('tedesco')->nullable()->default(false);
            $table->boolean('spagnolo')->nullable()->default(false);
            $table->boolean('russo')->nullable()->default(false);
            $table->text('altra_lingua')->nullable();

            $table->string('tipo')->nullable()->default(null);
            $table->string('apertura')->nullable()->default(null);
            $table->string('categoria')->nullable()->default(null);

            $table->boolean('piscina')->nullable()->default(false);
            $table->boolean('benessere')->nullable()->default(false);
            $table->boolean('disabili')->nullable()->default(false);
            $table->boolean('organizzazione_matrimoni')->nullable()->default(false);
            $table->boolean('organizzazione_cresime')->nullable()->default(false);
            $table->boolean('organizzazione_comunioni')->nullable()->default(false);
            $table->text('note_organizzazione_matrimoni')->nullable();

            $table->string('nome_file')->nullable()->default(null);
            $table->date('data_firma')->nullable()->default(null);

            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'ServiziHotelTableSeeder',
            '--force' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblServiziHotel');
    }
}
