<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEVMesi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblEVMesi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',100);
            $table->string('numero',10);
            $table->string('anno',10);
            $table->timestamps();
        });


         Artisan::call( 'db:seed', [
             '--class' => 'EvMesiTableSeeder',
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
        Schema::dropIfExists('tblEVMesi');
    }
}
