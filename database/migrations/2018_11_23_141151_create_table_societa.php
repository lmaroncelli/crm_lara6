<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSocieta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblSocieta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("cliente_id")->unsigned()->default(0);
            $table->integer("ragionesociale_id")->unsigned()->default(0);
            $table->text('note')->nullable()->default(null);
            $table->string('banca')->nullable();
            $table->string('abi')->nullable();
            $table->string('cab')->nullable();
            $table->string('iban')->nullable();
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'SocietaTableSeeder',
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
        Schema::dropIfExists('tblSocieta');
    }
}
