<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoglioAssociaServizi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblFoglioAssociaServizi', function (Blueprint $table) {
            $table->id();
            $table->integer('foglio_id')->nullable()->default(null);
            $table->integer('servizio_id')->nullable()->default(null);
            $table->string('note')->nullable()->default(null);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'FoglioAssociaServiziSeeder',
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
        Schema::dropIfExists('tblFoglioAssociaServizi');
    }
}
