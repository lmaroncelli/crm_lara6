<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Vetrina;

class SlotVetrina extends Model
{
   protected $table = 'tblSlotVetrine';

   protected $guarded = ['id'];



   public function vetrina()
   	{
     return $this->belongsTo(Vetrina::class, 'vetrina_id', 'id');
   	}
}
