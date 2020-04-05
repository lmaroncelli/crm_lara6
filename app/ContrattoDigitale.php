<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContrattoDigitale extends Model
{
   protected $table = 'tblContrattiDigitali';

   protected $guarded = ['id'];


   /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'data_creazione',
    ];



   public function servizi()
   {
       return $this->hasMany('App\ServizioDigitale', 'contratto_id', 'id');
   }


   public function servizi_venduti()
   {
       return $this->hasMany('App\ServizioDigitale', 'contratto_id', 'id')->where('sconto',0);
   }

   public function sconti()
   {
       return $this->hasMany('App\ServizioDigitale', 'contratto_id', 'id')->where('sconto',1);
   }


   public function commerciale()
   {
       return $this->belongsTo('App\User', 'user_id', 'id');
   }

   public function cliente()
   {
       return $this->belongsTo('App\Cliente', 'cliente_id', 'id');
   }
   
}
