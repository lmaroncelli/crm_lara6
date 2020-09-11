<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCommercialiMemorex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblCommercialiMemorex', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->timestamps();
        });

         Artisan::call( 'db:seed', [
             '--class' => 'CommercialiMemorexSeeder',
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
        Schema::dropIfExists('tblCommercialiMemorex');
    }
}
