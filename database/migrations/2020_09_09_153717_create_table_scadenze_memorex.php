<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableScadenzeMemorex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblScadenzeMemorex', function (Blueprint $table) {
            $table->id();
            $table->integer('commerciale_id')->unsigned();
            $table->enum('categoria', ['Info Alberghi','Milanomarittima.it','Hotel Manager'])->default('Info Alberghi');
            $table->string('titolo')->nullable()->default(null);
            $table->text('descrizione')->nullable();
            $table->string('giorno')->nullable()->default(null);
            $table->string('mese')->nullable()->default(null);
            $table->string('anno')->nullable()->default(null);
            $table->string('minuti')->nullable()->default(null);
            $table->string('ore')->nullable()->default(null);
            $table->date('data')->nullable()->default(null);
            $table->enum('priorita', ['Normale','Media','Alta','Amministrazione'])->default('Normale');
            $table->boolean('completato')->default(false);
            $table->date('data_disattivazione')->nullable()->default(null);
            $table->timestamps();
        });


          Artisan::call( 'db:seed', [
             '--class' => 'ScadenzeMemorexSeeder',
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
        Schema::dropIfExists('tblScadenzeMemorex');
    }
}
