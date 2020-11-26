<?php

use Illuminate\Database\Seeder;

class AdjustRigheFatturazioneSconto extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

     DB::connection('mysql')
     ->table('tblRigheFatturazione')
     ->where('perc_sconto',0)->where(function($q){
     		$q->where('totale_netto_scontato',0)->orWhereNull('totale_netto_scontato');
     }) 
     ->update(['totale_netto_scontato' => DB::raw('totale_netto')]);
     
    }
}
