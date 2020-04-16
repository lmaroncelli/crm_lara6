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

   /**
    * [servizi_venduti]
    * @return [type] [description]
    */
   public function servizi_venduti()
   {
       return $this->hasMany('App\ServizioDigitale', 'contratto_id', 'id')->where('sconto',0);
   }

   /**
    * [sconti ASSOCIATI AD UN SERVIZIO NON GENERICI]
    * @return [type] [description]
    */
   public function sconti_associati()
   {
       return $this->hasMany('App\ServizioDigitale', 'contratto_id', 'id')->where('sconto',1)->whereNotNull('servizio_scontato_id');
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
