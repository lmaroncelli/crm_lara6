<?php

namespace App;

use App\Cliente;
use App\Utility;
use App\Vetrina;
use Illuminate\Database\Eloquent\Model;

class SlotVetrina extends Model
{
   protected $table = 'tblSlotVetrine';

   protected $guarded = ['id'];

   protected $dates = [
     'data_disattivazione'
];




   public function vetrina()
   	{
     return $this->belongsTo(Vetrina::class, 'vetrina_id', 'id');
    }

  
  public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }


    public function setDataDisattivazioneAttribute($value)
    {
        $this->attributes['data_disattivazione'] = Utility::getCarbonDate($value);
    }

     
  
}
