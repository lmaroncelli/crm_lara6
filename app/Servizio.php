<?php

namespace App;

use App\Cliente;
use App\Fattura;
use App\Prodotto;
use App\RigaDiFatturazione;
use Illuminate\Database\Eloquent\Model;

class Servizio extends Model
{
   protected $table = 'tblServizi';

   protected $guarded = ['id'];

   protected $dates = [
       'created_at',
       'updated_at',
        'data_inizio',
        'data_fine'
   ];


   public function prodotto()
   {
       return $this->belongsTo(Prodotto::class, 'prodotto_id', 'id');
   }


   public function cliente()
   {
       return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
   }


  public function fattura()
   {
       return $this->belongsTo(Fattura::class, 'fattura_id', 'id');
   }


  public function rigaFattura()
  {
      return $this->belongsTo(RigaDiFatturazione::class, 'rigafatturazione_id', 'id');
  }

  /**
   * [nella fatturazione la multiselect che include i servizi da fatturare]
   * @return [type] [description]
   */
  public function getValueforRigaFatturazione()
    {
      $val =  $this->prodotto->nome . ': dal '. $this->data_inizio->format('d/m/Y'). ' al '. $this->data_fine->format('d/m/Y');
      if($this->note != '')
        {
        $val .= ' - ' .$this->note;
        }

      return $val;
    }
   

}
