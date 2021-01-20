<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentroBenessere extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblCentroBenessere', function (Blueprint $table) {
            $table->id();
            $table->integer('foglio_id')->default(0);
            $table->integer('sup_b')->default(0);
            $table->string('area_fitness', 2)->nullable()->default(null);
            $table->integer('sup_fitness')->default(0);
            $table->string('aperto_dal_b', 2)->nullable()->default(null);
            $table->string('aperto_al_b', 2)->nullable()->default(null);
            $table->boolean('aperto_annuale_b')->nullable()->default(false);
            
            $table->string('a_pagamento', 2)->nullable()->default(null);
            $table->boolean('in_hotel')->nullable()->default(false);
            $table->integer('distanza_hotel')->default(0);
            $table->integer('eta_minima')->default(0);
            $table->string('obbligo_prenotazione', 2)->nullable()->default(null);
            $table->string('uso_esclusivo')->nullable()->default(null);

            $table->boolean('piscina_benessere')->nullable()->default(false);
            $table->boolean('idromassaggio')->nullable()->default(false);
            $table->boolean('sauna_finlandese')->nullable()->default(false);
            $table->boolean('bagno_turco')->nullable()->default(false);
            $table->boolean('docce_emozionali')->nullable()->default(false);
            $table->boolean('cascate_ghiaccio')->nullable()->default(false);
            $table->boolean('aromaterapia')->nullable()->default(false);
            $table->boolean('percorso_kneipp')->nullable()->default(false);
            $table->boolean('cromoterapia')->nullable()->default(false);
            $table->boolean('massaggi')->nullable()->default(false);
            $table->boolean('trattamenti_estetici')->nullable()->default(false);
            $table->boolean('area_relax')->nullable()->default(false);
            $table->boolean('letto_marmo_riscaldato')->nullable()->default(false);
            $table->boolean('stanza_sale')->nullable()->default(false);
            $table->boolean('kit_benessere')->nullable()->default(false);
            $table->text('peculiarita')->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'CentroBenessereTableSeeder',
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
        Schema::dropIfExists('tblCentroBenessere');
    }
}
