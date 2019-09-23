<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblClienti', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_info")->default(0);
            $table->string('nome');
            $table->integer("localita_id")->unsigned()->default(0);
            $table->integer("gruppo_id")->unsigned()->default(0);
            $table->integer("tipo_id")->unsigned()->default(1);
            $table->string('cap')->nullable();
            $table->string('indirizzo')->nullable();
            $table->string('telefono')->nullable();
            $table->string('fax')->nullable();
            $table->string('cell')->nullable();
            $table->string('email')->nullable();
            $table->string('email_amministrativa')->nullable();
            $table->string('pec')->nullable();
            $table->string('codice_destinatario', 7)->nullable();
            $table->string('skype')->nullable();
            $table->text('note')->nullable();
            $table->text('note_2')->nullable();
            $table->integer("categoria_id")->unsigned()->default(0);
            $table->boolean('attivo');
            $table->boolean('attivo_IA');
            $table->date('data_attivazione')->nullable()->default(null);
            $table->date('data_attivazione_IA')->nullable()->default(null);
            $table->date('data_disattivazione')->nullable()->default(null);
            $table->date('data_disattivazione_IA')->nullable()->default(null);
            $table->string('web')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('sms')->nullable();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });

        Artisan::call( 'db:seed', [
             '--class' => 'ClientiTableSeeder',
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
        Schema::dropIfExists('tblClienti');
    }
}
