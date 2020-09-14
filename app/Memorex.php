<?php

namespace App;

use App\CommercialeMemorex;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Memorex extends Model
{
   protected $table = 'tblScadenzeMemorex';

   protected $guarded = ['id'];

   public function commerciale()
    {
        return $this->belongsTo(CommercialeMemorex::class, 'commerciale_id', 'id');
    }

    public function scopeNotHM($query)
      {
        return $query->where('categoria', '!=', 'Hotel Manager');
      }


    /*Filtri LISTING memorex */

    public function scopeScadute($query)
      {
        return $query->where('completato', 0)->where('data','<=',Carbon::today()->toDateString());
      }

    public function scopeNonScadute($query)
      {
        return $query->where('completato', 0)->where('data','>',Carbon::today()->toDateString());
      }

    

}
