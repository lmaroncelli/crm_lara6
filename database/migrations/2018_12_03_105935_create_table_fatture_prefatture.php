<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFatturePrefatture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblFatturePrefatture', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("fattura_id")->unsigned()->nullable()->default(null);
            $table->integer("prefattura_id")->unsigned()->nullable()->default(null);
            $table->timestamps();
        });


        Artisan::call( 'db:seed', [
             '--class' => 'FatturePrefattureTableSeeder',
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
        Schema::dropIfExists('tblFatturePrefatture');
    }
}
