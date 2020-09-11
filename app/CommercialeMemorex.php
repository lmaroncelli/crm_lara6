<?php

namespace App;

use App\Memorex;
use Illuminate\Database\Eloquent\Model;

class CommercialeMemorex extends Model
{
   protected $table = 'tblCommercialiMemorex';
   protected $guarded = ['id'];

   public function scadenze()
    {
        return $this->hasMany(Memorex::class, 'commerciale_id', 'id');
    }


}
