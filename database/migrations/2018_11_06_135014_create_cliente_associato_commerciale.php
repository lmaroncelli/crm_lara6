<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteAssociatoCommerciale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblClienteAssociatoCommerciale', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->index('cliente_id');
            $table->index('user_id');
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'ClientiAssociatiCommercialiTableSeeder',
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
        Schema::dropIfExists('tblClienteAssociatoCommerciale');
    }
}
