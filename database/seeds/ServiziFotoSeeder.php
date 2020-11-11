<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiziFotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
			{
			$foto  =  DB::connection('old')
												->table('foto')
												->select(DB::raw('id, id_cliente as cliente_id, anno, note'))
												->get();

				$foto = collect($foto)->map(function($x){ return (array) $x; })->toArray(); 

				DB::connection('mysql')->table('tblServiziFoto')->truncate();
				
				foreach ($foto as $foto) 
					{
					DB::connection('mysql')->table('tblServiziFoto')->insert($foto);
					}
			}
}
