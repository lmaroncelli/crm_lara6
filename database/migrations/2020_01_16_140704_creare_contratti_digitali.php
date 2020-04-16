<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreareContrattiDigitali extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblContrattiDigitali', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('cliente_id');
            $table->text('dati_cliente')->nullable();
            $table->datetime('data_creazione')->nullable()->default(null);
            $table->enum('tipo_contratto', ['nuovo','rinnovo','cambio_gestione'])->default('rinnovo');
            $table->string('segnalatore')->nullable()->default(null);
            $table->text('dati_fatturazione')->nullable();
            $table->text('dati_referente')->nullable();
            $table->string('iban')->nullable()->default(null);
            $table->text('iban_importato')->nullable();
            $table->string('pec')->nullable()->default(null);
            $table->string('codice_destinatario', 7)->nullable()->default(null);
            $table->enum('condizioni_pagamento', ['RIBA','ASSEGNO BANCARIO','BONIFICO','CONTANTI','NESSUNO','GRATUITO'])->default('RIBA');
            $table->string('data_pagamento')->nullable()->default(null);
            $table->text('note')->nullable();
            $table->string('sito_web')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('email_amministrativa')->nullable()->default(null);
            $table->string('nome_file')->nullable()->default(null);
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'ContrattiDigitaliTableSeeder',
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
        Schema::dropIfExists('tblContrattiDigitali');
    }
}
