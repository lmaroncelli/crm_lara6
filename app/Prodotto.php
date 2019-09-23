<?php

namespace App;

use App\Servizio;
use Illuminate\Database\Eloquent\Model;

class Prodotto extends Model
{
   protected $table = 'tblProdotti';

   protected $guarded = ['id'];


   public function servizi()
   {
       return $this->hasMany(Servizio::class, 'prodotto_id', 'id');
   }
   

}
