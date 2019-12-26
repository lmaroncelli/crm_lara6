<?php

namespace App;

use App\Localita;
use App\TipoEvidenza;
use Illuminate\Database\Eloquent\Model;

class MacroLocalita extends Model
{
   protected $table = 'tblMacroLocalita';

   protected $guarded = ['id'];

   public function localita()
   {
       return $this->hasMany(Localita::class, 'macrolocalita_id', 'id');
   }

   public function tipiEvidenza()
   {
       return $this->hasMany(TipoEvidenza::class, 'macrolocalita_id', 'id');
   }

}
