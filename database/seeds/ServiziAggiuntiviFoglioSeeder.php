<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiziAggiuntiviFoglioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tblServiziAggiuntivi  =  DB::connection('old')
        ->table('associazione_serviziaggiuntivi_in_hotel')
        ->select(DB::raw('id, nome_servizio as nome, id_elenco as foglio_id, id_gruppo as gruppo_id'))
        ->get();

        $tblServiziAggiuntivi = collect($tblServiziAggiuntivi)->map(function ($x) {
            return (array) $x;
        })->toArray();

        DB::connection('mysql')->table('tblServiziAggiuntiviFoglio')->truncate();

        foreach ($tblServiziAggiuntivi as $row) {
            DB::connection('mysql')->table('tblServiziAggiuntiviFoglio')->insert($row);
        }
    }
}
