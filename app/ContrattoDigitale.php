<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContrattoDigitale extends Model
{
   protected $table = 'tblContrattiDigitali';

   protected $guarded = ['id'];


   public function servizi()
   {
       return $this->hasMany('App\ServizioDigitale', 'contratto_id', 'id');
   }
   
}
