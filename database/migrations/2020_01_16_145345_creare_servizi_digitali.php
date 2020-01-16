<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreareServiziDigitali extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblServiziDigitali', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('contratto_id')->unsigned();
            $table->integer('servizio_scontato_id')->unsigned();
            $table->string('nome')->nullable()->default('null');
            $table->string('localita')->nullable()->default('null');
            $table->string('pagina')->nullable()->default('null');
            $table->text('altro_servizio');
            $table->string('dal',50)->nullable()->default('null');
            $table->string('al',50)->nullable()->default('null');
            $table->integer('qta')->nullable()->default(1);
            $table->decimal('importo', 10, 2)->default(0.00);
            $table->boolean('sconto')->nullable()->default(false);
            $table->boolean('scontato')->nullable()->default(false);
            
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'ServiziDigitaliTableSeeder',
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
        Schema::dropIfExists('tblServiziDigitali');
    }
}
