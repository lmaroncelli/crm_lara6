<?php

namespace App;

use App\CommercialeMemorex;
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

}
