<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRigaConteggioServizio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblRigaConteggioServizio', function (Blueprint $table) {
            $table->id();
            $table->integer('riga_conteggio_id')->unsigned();
            $table->integer('servizio_id')->unsigned();
            $table->index('riga_conteggio_id');
            $table->index('servizio_id');
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });

        Artisan::call( 'db:seed', [
            '--class' => 'RigaConteggioServizioSeeder',
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
        Schema::dropIfExists('tblRigaConteggioServizio');
    }
}
