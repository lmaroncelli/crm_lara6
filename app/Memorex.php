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


}
