<?php

namespace App;

use App\Evidenza;
use App\TipoEvidenza;
use Illuminate\Database\Eloquent\Model;

class EvidenzaMese extends Model
{
  protected $table = 'tblEVMesi';

  protected $guarded = ['id'];

  


  public function tipiEvidenze()
   {
       return $this->belongsToMany(TipoEvidenza::class, 'tblEVTipiEvidenzeMesi', 'mese_id', 'tipoevidenza_id');
   }


   public function evidenze()
   {
       return $this->belongsToMany(Evidenza::class, 'tblEVEvidenzeMesi', 'mese_id', 'evidenza_id');
   }




}
