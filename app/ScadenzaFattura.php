<?php

namespace App;

use App\Fattura;
use App\Utility;
use Carbon\Carbon;
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


    public function scopePagata($query)
    {
        return $query->where('pagata',1);
    }

    public function scopeNotPagata($query)
    {
        return $query->where('pagata',0);
    }


    public function getGiorniRimastiAttribute()
      {
        return Carbon::now()->diffInDays($this->data_scadenza, false);
      }
   

}
