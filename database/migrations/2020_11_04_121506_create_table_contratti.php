<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableContratti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblContratti', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id');
            $table->enum('tipo', ['Info Alberghi','Hotel Manager'])->default('Info Alberghi');
            $table->string('titolo')->nullable()->default(null);
            $table->string('anno')->nullable()->default(null);
            $table->string('nome_file')->nullable()->default(null);
            $table->timestamp('data_inserimento')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });

        Artisan::call('db:seed', [
            '--class' => 'ContrattiSeeder',
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
        Schema::dropIfExists('tblContratti');
    }
}
