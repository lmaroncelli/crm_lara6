<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiziAggiuntiviFoglio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblServiziAggiuntiviFoglio', function (Blueprint $table) {
            $table->id();
            $table->integer('foglio_id')->nullable()->default(null);
            $table->integer('gruppo_id')->nullable()->default(null);
            $table->string('nome')->nullable()->default(null);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'ServiziAggiuntiviFoglioSeeder',
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
        Schema::dropIfExists('tblServiziAggiuntiviFoglio');
    }
}
