<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVetrine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblVetrine', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable()->default(null);
            $table->text('descrizione')->nullable();
            $table->enum('tipo',['Principale','Limitrofa'])->nullable()->default('Principale');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblVetrine');
    }
}
