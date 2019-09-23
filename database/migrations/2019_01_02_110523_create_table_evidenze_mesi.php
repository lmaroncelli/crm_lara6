<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEvidenzeMesi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblEVEvidenzeMesi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("evidenza_id")->unsigned()->nullable()->default(null);
            $table->integer("mese_id")->unsigned()->nullable()->default(null);
            $table->integer('cliente_id')->nullable()->default(0);
            $table->integer('user_id')->unsigned()->nullable()->default(0);
            $table->boolean('acquistata')->default(false);
            $table->boolean('prelazionata')->default(false);
            $table->integer('servizioweb_id')->unsigned()->nullable()->default(0);
            $table->string("nome_hotel")->nullable()->default(null);
            $table->timestamps();
        });


        Artisan::call( 'db:seed', [
             '--class' => 'EvidenzeMesiTableSeeder',
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
        Schema::dropIfExists('tblEVEvidenzeMesi');
    }
}
