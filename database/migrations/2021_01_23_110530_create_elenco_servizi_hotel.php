<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElencoServiziHotel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblServiziFoglio', function (Blueprint $table) {
            $table->id();
            $table->integer('gruppo_id')->nullable()->default(null);
            $table->string('nome')->nullable()->default(null);
            $table->integer('info_id')->nullable()->default(null);
            $table->integer('order')->nullable()->default(null);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'ElencoServiziHotelSeeder',
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
        Schema::dropIfExists('tblServiziFoglio');
    }
}
