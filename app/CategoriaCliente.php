<?php

namespace App;


use App\Cliente;
use Illuminate\Database\Eloquent\Model;

class CategoriaCliente extends Model
{
   protected $table = 'tblCategorieClienti';

   protected $guarded = ['id'];

   public function clienti()
   {
       return $this->hasMany(Cliente::class, 'categoria_id', 'id');
   }

}
