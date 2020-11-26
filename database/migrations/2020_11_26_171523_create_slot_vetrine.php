<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotVetrine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblSlotVetrine', function (Blueprint $table) {
            $table->id();
            $table->integer('vetrina_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->date('data_disattivazione')->nullable()->default(null);
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblSlotVetrine');
    }
}
