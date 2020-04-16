<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServizioDigitale extends Model
{
  protected $table = 'tblServiziDigitali';

  protected $guarded = ['id'];
  
  public function contratto()
  {
      return $this->belongsTo('App\ContrattoDigitale', 'contratto_id', 'id');
  }


  public function scontoAssociato()
    {
    return $this->hasOne(ServizioDigitale::class, 'servizio_scontato_id', 'id');
    }
   


  public function togliSconto()
    {
    $this->scontato = 0;
    $this->save();
    }



}
