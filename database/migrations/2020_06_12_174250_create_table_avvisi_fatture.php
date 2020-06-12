<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAvvisiFatture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblAvvisiFatture', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enaum('tipo_pagamento',['scaduto','in scadenza'])->default('in scadenza');
            $table->text('testo')->nullable();
            $table->string('email')->nullable()->default(null);
            $table->integer('giorni')->nullable()->default(0);
            $table->datetime('data')->nullable()->default(null);
            $table->integer("fattura_id")->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblAvvisiFatture');
    }
}
