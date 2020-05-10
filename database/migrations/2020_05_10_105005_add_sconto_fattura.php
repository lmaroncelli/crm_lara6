<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScontoFattura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblRigheFatturazione', function (Blueprint $table) {
            $table->integer('perc_sconto')->after('totale_netto')->nullable()->default(0);
            $table->decimal('totale_netto_scontato', 10, 2)->after('perc_sconto')->nullable()->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblRigheFatturazione', function (Blueprint $table) {
            $table->dropColumn(['perc_sconto','totale_netto_scontato']);
        });
    }
}
