<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableModalitaVendita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblModalitaVendita', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable()->defalut(null);
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });


        Artisan::call( 'db:seed', [
            '--class' => 'ModalitaVenditaSeeder',
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
        Schema::dropIfExists('tblModalitaVendita');
    }
}
