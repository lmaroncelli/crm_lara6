<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$tblClienti  =  DB::connection('old')
    	                ->table('clienti')
    	                ->select(DB::raw('id, nome, id_localita as localita_id, id_gruppo as gruppo_id, cap, indirizzo, id_tipo as tipo_id, telefono, fax, cell, email, email_amministrativa, pec, codice_destinatario, skype, note, note_2, id_categoria as categoria_id, attivo, attivo_IA, data_attivazione, data_attivazione_IA, data_disattivazione, data_disattivazione_IA, web, id_info, whatsapp, sms'))
    	                ->get();

    	$tblClienti = collect($tblClienti)->map(function($x){ return (array) $x; })->toArray(); 

    	DB::connection('mysql')->table('tblClienti')->truncate();
    	
    	foreach ($tblClienti as $cliente) 
    		{
                $cliente['data_attivazione'] = (is_null($cliente['data_attivazione']) || $cliente['data_attivazione'] == 0) ? null: Carbon::createFromTimestamp($cliente['data_attivazione'])->toDateString();

                $cliente['data_attivazione_IA'] = (is_null($cliente['data_attivazione_IA']) || $cliente['data_attivazione_IA'] == 0) ? null : Carbon::createFromTimestamp($cliente['data_attivazione_IA'])->toDateString();

                $cliente['data_disattivazione'] = (is_null($cliente['data_disattivazione']) || $cliente['data_disattivazione'] == 0) ? null:  Carbon::createFromTimestamp($cliente['data_disattivazione'])->toDateString();
                
                $cliente['data_disattivazione_IA'] = (is_null($cliente['data_disattivazione_IA']) || $cliente['data_disattivazione_IA'] == 0) ? null : Carbon::createFromTimestamp($cliente['data_disattivazione_IA'])->toDateString();
    	       
               DB::connection('mysql')->table('tblClienti')->insert($cliente);
    		}

    }
}
