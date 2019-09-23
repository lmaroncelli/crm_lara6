<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRagioneSociale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblRagioneSociale', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->nullable();
            $table->integer("localita_id")->unsigned()->default(0);
            $table->string('cap',50)->nullable();
            $table->string('indirizzo')->nullable();
            $table->string('piva')->nullable();
            $table->string('cf')->nullable();
            $table->string('pec')->nullable();
            $table->string('codice_sdi')->nullable();
            $table->text('note')->nullable()->default(null);
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'RagioneSocialeTableSeeder',
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
        Schema::dropIfExists('tblRagioneSociale');
    }
}
