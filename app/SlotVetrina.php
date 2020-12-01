<?php

namespace App;

use App\Cliente;
use App\Vetrina;
use Illuminate\Database\Eloquent\Model;

class SlotVetrina extends Model
{
   protected $table = 'tblSlotVetrine';

   protected $guarded = ['id'];



   public function vetrina()
   	{
     return $this->belongsTo(Vetrina::class, 'vetrina_id', 'id');
    }

  
  public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

     
  
}
