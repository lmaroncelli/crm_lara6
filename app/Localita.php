<?php

namespace App;

use App\Cliente;
use App\Comune;
use App\MacroLocalita;
use Illuminate\Database\Eloquent\Model;

class Localita extends Model
{
   protected $table = 'tblLocalita';

   protected $guarded = ['id'];

   public function clienti()
   {
       return $this->hasMany(Cliente::class, 'localita_id', 'id');
   }

   public function comune()
   {
       return $this->belongsTo(Comune::class, 'comune_id', 'id');
   }

   public function macroLocalita()
   {
       return $this->belongsTo(MacroLocalita::class, 'macrolocalita_id', 'id');
   }

}
