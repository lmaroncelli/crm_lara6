<?php

namespace App;

use App\Localita;
use App\Societa;
use Illuminate\Database\Eloquent\Model;

class RagioneSociale extends Model
{
   protected $table = 'tblRagioneSociale';

   protected $guarded = ['id'];



   public function societa()
   {
       return $this->hasMany(Societa::class, 'ragionesociale_id', 'id');
   }


   public function localita()
    {
        return $this->belongsTo(Localita::class, 'localita_id', 'id');
    }


    /*
    used:
    App\Http\Composers\FattureFormComposer
    App\Http\Controllers\ClientiFatturazioniController
     */
    public static function getListForSelectModal($societa_ids_to_exlude = [])
      {
        if(count($societa_ids_to_exlude))
          {
          return self::has('societa')
                            ->with([
                              'societa' => function($q) use ($societa_ids_to_exlude) {
                                $q->whereNotIn('id', $societa_ids_to_exlude);
                              },
                              'societa.cliente' => function($q){
                                $q->orderBy('id_info');
                              }
                            ])
                        ->get();
          }
        else
          {
          return self::has('societa')
                            ->with([
                              'societa.cliente' => function($q){
                                $q->orderBy('id_info');
                              }
                            ])
                        ->get();
          }
      }

   

}
