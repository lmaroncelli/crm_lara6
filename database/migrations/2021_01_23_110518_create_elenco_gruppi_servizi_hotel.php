<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElencoGruppiServiziHotel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblElencoGruppiServiziHotel', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable()->default(null);
            $table->integer('info_id')->nullable()->default(null);
            $table->integer('order')->nullable()->default(null);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'ElencoGruppiServiziHotelSeeder',
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
        Schema::dropIfExists('tblElencoGruppiServiziHotel');
    }
}
