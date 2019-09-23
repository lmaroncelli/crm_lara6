<?php

namespace App;

use App\Fattura;
use App\Servizio;
use Illuminate\Database\Eloquent\Model;

class RigaDiFatturazione extends Model
{
   protected $table = 'tblRigheFatturazione';

   protected $guarded = ['id'];


   public function fattura()
   {
       return $this->belongsTo(Fattura::class, 'fattura_id', 'id');
   }


   public function servizi()
   {
       return $this->hasMany(Servizio::class, 'rigafatturazione_id', 'id');
   }


   /**
      * Override parent boot and Call deleting event
      *
      * @return void
      */
      protected static function boot() 
       {
         parent::boot();

         static::deleting(function($righe) {
            foreach ($righe->servizi as $servizio) {
               $servizio->fattura_id = NULL;
               $servizio->rigafatturazione_id = NULL;
               $servizio->save();
            }
         });
       }

   

}
