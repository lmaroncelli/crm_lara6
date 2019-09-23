<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComuni extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblComuni', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('provincia_id')->unsigned();
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'ComuniTableSeeder',
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
        Schema::dropIfExists('tblComuni');
    }
}
