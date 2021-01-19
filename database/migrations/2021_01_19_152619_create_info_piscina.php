<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoPiscina extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblInfoPiscina', function (Blueprint $table) {
            $table->id();
            $table->integer('foglio_id')->default(0);
            $table->integer('sup')->default(0);
            $table->integer('h')->default(0);
            $table->integer('h_min')->default(0);
            $table->integer('h_max')->default(0);
            $table->string('aperto_dal', 2)->nullable()->default(null);
            $table->string('aperto_al', 2)->nullable()->default(null);
            $table->boolean('aperto_annuale')->nullable()->default(false);
            $table->string('espo_sole', 2)->nullable()->default(null);
            $table->boolean('espo_sole_tutto_giorno')->nullable()->default(false);
            $table->string('posizione')->nullable()->default(null);
            $table->boolean('coperta')->nullable()->default(false);
            $table->boolean('riscaldata')->nullable()->default(false);
            $table->boolean('salata')->nullable()->default(false);
            $table->boolean('idro')->nullable()->default(false);
            $table->boolean('idro_cervicale')->nullable()->default(false);
            $table->boolean('scivoli')->nullable()->default(false);
            $table->boolean('trampolino')->nullable()->default(false);
            $table->boolean('aperitivi')->nullable()->default(false);
            $table->boolean('getto_bolle')->nullable()->default(false);
            $table->boolean('cascata')->nullable()->default(false);
            $table->boolean('musica_sub')->nullable()->default(false);
            $table->boolean('wi_fi')->nullable()->default(false);
            $table->boolean('pagamento')->nullable()->default(false);
            $table->string('vasca_posizione')->nullable()->default(null);
            $table->boolean('salvataggio')->nullable()->default(false);
            $table->boolean('nuoto_contro')->nullable()->default(false);
            $table->text('peculiarita_piscina')->nullable();
            $table->integer('lettini_dispo')->default(0);
            $table->integer('vasca_bimbi_h')->default(0);
            $table->integer('vasca_bimbi_sup')->default(0);
            $table->integer('vasca_idro_posti_dispo')->default(0);
            $table->boolean('vasca_idro_riscaldata')->nullable()->default(false);
            $table->boolean('vasca_pagamento')->nullable()->default(false);
            $table->integer('vasca_idro_n_dispo')->default(0);
            $table->boolean('vasca_bimbi_riscaldata')->nullable()->default(false);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'InfoPiscinaTableSeeder',
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
        Schema::dropIfExists('tblInfoPiscina');
    }
}
