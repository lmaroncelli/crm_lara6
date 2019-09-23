<?php

namespace App;


use App\Cliente;
use Illuminate\Database\Eloquent\Model;

class TipologiaCliente extends Model
{
   protected $table = 'tblTipologieClienti';

   protected $guarded = ['id'];

   public function clienti()
   {
       return $this->hasMany(Cliente::class, 'tipo_id', 'id');
   }

}
