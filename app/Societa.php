<?php

namespace App;

use App\Cliente;
use App\Fattura;
use App\RagioneSociale;
use Illuminate\Database\Eloquent\Model;

class Societa extends Model
{
   protected $table = 'tblSocieta';

   protected $guarded = ['id'];



   public function ragioneSociale()
   {
       return $this->belongsTo(RagioneSociale::class, 'ragionesociale_id', 'id');
   }


    public function cliente()
   {
       return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
   }


  public function fatture()
  {
      return $this->hasMany(Fattura::class, 'societa_id', 'id');
  }

  public function prefatture()
  {
      return $this->hasMany(Fattura::class, 'societa_id', 'id')->where('tipo_id', 'PF');
  }
   

}
