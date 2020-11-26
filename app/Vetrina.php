<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SlotVetrina;

class Vetrina extends Model
{
    protected $table = 'tblVetrine';

   protected $guarded = ['id'];


   public function slot()
  	{
      return $this->hasMany(SlotVetrina::class, 'vetrina_id', 'id');
  	}
}
