<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRegioni extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblRegioni', function (Blueprint $table) {
            $table->increments('id');
             $table->string('nome');
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'RegioniTableSeeder',
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
        Schema::dropIfExists('tblRegioni');
    }
}
