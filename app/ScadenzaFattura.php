<?php

namespace App;

use App\Fattura;
use App\Utility;
use Illuminate\Database\Eloquent\Model;

class ScadenzaFattura extends Model
{
   protected $table = 'tblScadenzeFattura';

   protected $guarded = ['id'];

   protected $dates = [
       'created_at',
       'updated_at',
        'data_scadenza',
   ];



   public function fattura()
   {
       return $this->belongsTo(Fattura::class, 'fattura_id', 'id');
   }



   public function setDataScadenzaAttribute($value)
    {
        $this->attributes['data_scadenza'] = Utility::getCarbonDate($value);
    }
   

}
