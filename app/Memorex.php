<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Memorex extends Model
{
   protected $table = 'tblScadenzeMemorex';

   protected $guarded = ['id'];

   public function commerciale()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeNotHM($query)
      {
        return $query->where('categoria', '!=', 'Hotel Manager');
      }

}
