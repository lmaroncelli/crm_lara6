<?php


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RigheConteggiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tblRigheConteggi  =  DB::connection('old')
    			                ->table('righe_conteggi')
    			                ->select(DB::raw('id, id_conteggio as conteggio_id, id_cliente as cliente_id, v_totale as totale, v_reale as reale, modalita as modalita_id, descrizione, percentuale'))
    			                ->get();

        $tblRigheConteggi = collect($tblRigheConteggi)->map(function($x){ return (array) $x; })->toArray(); 

        DB::connection('mysql')->table('tblRigheConteggi')->truncate();
        
        foreach ($tblRigheConteggi as $riga) 
            {
                DB::connection('mysql')->table('tblRigheConteggi')->insert($riga);
            }
    }
}
