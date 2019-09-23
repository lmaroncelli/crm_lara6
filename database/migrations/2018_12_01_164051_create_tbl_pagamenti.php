<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPagamenti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblPagamenti', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cod',5)->nullable()->dafautl(null);
            $table->string('cod_PA',4)->nullable()->dafautl(null);
            $table->string('nome',100);
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'PagamentiTableSeeder',
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
        Schema::dropIfExists('tblPagamenti');
    }
}
