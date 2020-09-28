<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRigheConteggi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblRigheConteggi', function (Blueprint $table) {
            $table->id();
            $table->integer('conteggio_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->integer('modalita_id')->unsigned();
            $table->decimal('totale', 10, 2)->default(0.00);
            $table->decimal('reale', 10, 2)->default(0.00);
            $table->decimal('percentuale', 10, 2)->default(0.00);
            $table->string('descrizione')->nullable()->default(null);
            $table->timestamps();
        });

        Artisan::call( 'db:seed', [
            '--class' => 'RigheConteggiSeeder',
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
        Schema::dropIfExists('tblRigheConteggi');
    }
}
