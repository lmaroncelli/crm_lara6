<?php

namespace App;

use App\Localita;
use App\Provincia;
use Illuminate\Database\Eloquent\Model;

class Comune extends Model
{
   protected $table = 'tblComuni';

   protected $guarded = ['id'];

   public function localita()
   {
       return $this->hasMany(Localita::class, 'comune_id', 'id');
   }

    public function provincia()
   {
       return $this->belongsTo(Provincia::class, 'provincia_id', 'id');
   }

}
