<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTipiEvidenzeNese extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblEVTipiEvidenzeMesi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("tipoevidenza_id")->unsigned()->nullable()->default(null);
            $table->integer("mese_id")->unsigned()->nullable()->default(null);
            $table->integer("costo")->default(0);
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'TipiEvidenzeMesiTableSeeder',
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
        Schema::dropIfExists('tblEVTipiEvidenzeMesi');
    }
}
