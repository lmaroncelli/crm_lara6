<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTblEVEvidenze extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblEVEvidenze', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("tipoevidenza_id")->unsigned()->nullable()->default(null);
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'EvidenzeTableSeeder',
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
        Schema::dropIfExists('tblEVEvidenze');
    }
}
