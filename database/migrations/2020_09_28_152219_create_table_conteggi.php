<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableConteggi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblConteggi', function (Blueprint $table) {
            $table->id();
            $table->string('titolo')->nullable()->default(null);
            $table->integer('user_id')->unsigned();
            $table->boolean('terminato')->default(0);
            $table->boolean('approvato')->default(0);
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
            '--class' => 'ConteggiSeeder',
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
        Schema::dropIfExists('tblConteggi');
    }
}
