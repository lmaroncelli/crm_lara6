<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTipiEvidenze extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblEVTipiEvidenze', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("macrolocalita_id")->nullable()->default(null);
            $table->string('nome',150);
            $table->integer("n_max_visibile")->default(1);
            $table->integer("n_min_mesi")->default(1);
            $table->integer("ordine")->default(1);
            $table->enum('macrotipologia',['OFFERTE','SERVIZI','TRATTAMENTI','PARCHI DIVERTIMENTO'])->default('OFFERTE');
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'TipiEvidenzeTableSeeder',
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
        Schema::dropIfExists('tblEVTipiEvidenze');
    }
}
