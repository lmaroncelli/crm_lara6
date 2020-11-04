<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContrattiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contratti  =  DB::connection('old')
       	                ->table('contratti')
       	                ->select(DB::raw('id, titolo, anno, id_tipo as tipo, id_cliente as cliente_id, nome_file, data_inserimento'))
                         ->get();
                         
      $contratti = collect($contratti)->map(function($x){ return (array) $x; })->toArray(); 

      DB::connection('mysql')->table('tblContratti')->truncate();
      
        foreach ($contratti as $contratto) 
        {
        $contratto['tipo'] == 1 ? $contratto['tipo'] = 'Info Alberghi' : $contratto['tipo'] = 'Hotel Manager';
        DB::connection('mysql')->table('tblContratti')->insert($contratto);
        }
    }
}
