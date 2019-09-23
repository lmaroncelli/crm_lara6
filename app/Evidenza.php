<?php

namespace App;


use App\EvidenzaMese;
use App\TipoEvidenza;
use Illuminate\Database\Eloquent\Model;

class Evidenza extends Model
{
   protected $table = 'tblEVEvidenze';

   protected $guarded = ['id'];


   public function tipo()
   {
       return $this->belongsTo(TipoEvidenza::class, 'tipoevidenza_id', 'id');
   }


   public function mesi()
   {
       return $this->belongsToMany(EvidenzaMese::class, 'tblEVEvidenzeMesi', 'evidenza_id', 'mese_id');
   }

   
}
