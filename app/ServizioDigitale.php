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


}
