<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableScadenzeFattura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblScadenzeFattura', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("fattura_id")->unsigned()->default(0);
            $table->decimal('importo', 10, 2)->default(0.00);
            $table->date('data_scadenza')->nullable()->default(null);
            $table->text('note')->nullable()->default(null);
            $table->boolean('pagata')->default(false);
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'ScadenzeFatturaTableSeeder',
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
        Schema::dropIfExists('tblScadenzeFattura');
    }
}
