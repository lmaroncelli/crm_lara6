<?php

namespace App;


use App\Comune;
use App\Regione;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
   protected $table = 'tblProvince';

   protected $guarded = ['id'];

   public function comuni()
   {
       return $this->hasMany(Comune::class, 'provincia_id', 'id');
   }

    public function regione()
   {
       return $this->belongsTo(Regione::class, 'regione_id', 'id');
   }

}
