<?php

namespace App;


use App\Cliente;
use App\Utility;
use Illuminate\Database\Eloquent\Model;

class CategoriaCliente extends Model
{
   protected $table = 'tblCategorieClienti';

   protected $guarded = ['id'];

   public function clienti()
   {
       return $this->hasMany(Cliente::class, 'categoria_id', 'id');
   }


   // * es: $c->name => "&#9733;&#9733;&#9733;&#9733;&#9733;"
   public function getNameAttribute()
    {
        if( isset(Utility::getHotelCategoria()[$this->id]) ) {
            return Utility::getHotelCategoria()[$this->id];
        } else {
            return null;
        }

    }

    public function getNamePdfAttribute()
    {
        if (isset(Utility::getHotelCategoriaPdf()[$this->id])) {
            return Utility::getHotelCategoriaPdf()[$this->id];
        } else {
            return null;
        }
    }

}
