<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFatture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblFatture', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipo_id',['F','PF','NC'])->default('F');
            $table->string('numero_fattura',50)->nullable()->default('');
            $table->string('numero_prefattura',50)->nullable()->default('');
            $table->date('data')->nullable()->default(null);
            $table->integer("pagamento_id")->default(0);
            $table->integer("societa_id")->unsigned()->default(0);
            $table->text('note')->nullable()->default(null);
            $table->decimal('totale', 10, 2)->default(0.00);
            $table->decimal('da_fatturare', 10, 2)->default(0.00);
            $table->boolean('pagata')->default(false);
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'FattureTableSeeder',
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
        Schema::dropIfExists('tblFatture');
    }
}
