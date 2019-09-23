<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRigaFatturazioneIdToServizi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblServizi', function (Blueprint $table) {
            $table->integer("rigafatturazione_id")->after('fattura_id')->unsigned()->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblServizi', function (Blueprint $table) {
            $table->dropColumn('rigafatturazione_id');
        });
    }
}
