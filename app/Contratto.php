<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contratto extends Model
{
   protected $table = 'tblContratti';

   protected $guarded = ['id'];


   /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'data_inserimento',
    ];


   public function cliente()
   {
       return $this->belongsTo('App\Cliente', 'cliente_id', 'id');
   }
   
}
