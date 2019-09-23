<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMacrolocalita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblMacroLocalita', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('ordine')->default(0);
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'MacroLocalitaTableSeeder',
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
        Schema::dropIfExists('tblMacroLocalita');
    }
}
