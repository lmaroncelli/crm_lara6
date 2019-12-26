<?php

namespace App;


use App\Evidenza;
use App\EvidenzaMese;
use App\MacroLocalita;
use Illuminate\Database\Eloquent\Model;

class TipoEvidenza extends Model
{
   protected $table = 'tblEVTipiEvidenze';

   protected $guarded = ['id'];

   public function evidenze()
   {
       return $this->hasMany(Evidenza::class, 'tipoevidenza_id', 'id');
   }

   public function mesi()
   {
       return $this->belongsToMany(EvidenzaMese::class, 'tblEVTipiEvidenzeMesi', 'tipoevidenza_id', 'mese_id');
   }

   public function macroLocalita()
   {
       return $this->belongsTo(MacroLocalita::class, 'macrolocalita_id', 'id');
   }

}
