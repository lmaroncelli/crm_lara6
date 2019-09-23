<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRigheFatturazione extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblRigheFatturazione', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("fattura_id")->unsigned()->default(0);
            $table->text('servizio')->nullable()->default(null);
            $table->decimal('prezzo', 10, 2)->default(0.00);
            $table->integer('qta')->default(0);
            $table->decimal('totale_netto', 10, 2)->default(0.00);
            $table->integer('al_iva')->default(0);
            $table->decimal('iva', 10, 2)->default(0.00);
            $table->decimal('totale', 10, 2)->default(0.00);
            $table->timestamps();
        });


        Artisan::call( 'db:seed', [
             '--class' => 'RigheFatturazioneTableSeeder',
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
        Schema::dropIfExists('tblRigheFatturazione');
    }
}
