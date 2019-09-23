<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiziTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblServizi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("cliente_id")->unsigned()->nullable()->default(null);
            $table->integer("prodotto_id")->unsigned()->nullable()->default(null);
            $table->integer("fattura_id")->unsigned()->nullable()->default(null);
            $table->boolean('attivo')->default(true);
            $table->date('data_inizio')->nullable()->default(null);
            $table->date('data_fine')->nullable()->default(null);
            $table->text('note')->nullable()->default(null);
            $table->text('note_commerciale')->nullable()->default(null);
            $table->boolean('archiviato')->default(false);
            $table->boolean('da_pagare_reminder')->default(false);
            $table->boolean('archivia_alla_scadenza')->default(false);
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'ServiziTableSeeder',
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
        Schema::dropIfExists('tblServizi');
    }
}
