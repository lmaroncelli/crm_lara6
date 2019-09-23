<?php

namespace App;

use App\Cliente;
use App\Localita;
use Illuminate\Database\Eloquent\Model;

class MacroLocalita extends Model
{
   protected $table = 'tblMacroLocalita';

   protected $guarded = ['id'];

   public function localita()
   {
       return $this->hasMany(Localita::class, 'macrolocalita_id', 'id');
   }

}
