<?php

namespace App;

use App\Cliente;
use Illuminate\Database\Eloquent\Model;

class GruppoCliente extends Model
{
   protected $table = 'tblGruppiClienti';

   protected $guarded = ['id'];

   public function clienti()
   {
       return $this->hasMany(Cliente::class, 'gruppo_id', 'id')->orderBy('nome');
   }

}
