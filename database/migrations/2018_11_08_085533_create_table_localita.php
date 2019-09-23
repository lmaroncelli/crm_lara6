<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLocalita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblLocalita', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('comune_id')->unsigned();
            $table->integer('macrolocalita_id')->unsigned();
            $table->timestamps();
        });

         Artisan::call( 'db:seed', [
             '--class' => 'LocalitaTableSeeder',
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
        Schema::dropIfExists('tblLocalita');
    }
}
