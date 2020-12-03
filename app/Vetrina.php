<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SlotVetrina;

class Vetrina extends Model
{
    protected $table = 'tblVetrine';

   protected $fillable = ['nome','descrizione','tipo'];


   public function slots()
  	{
      return $this->hasMany(SlotVetrina::class, 'vetrina_id', 'id');
      }
      
    
    public function destroyMe()
      {
      foreach ($this->slots as $row) 
        {
        $row->delete();
        }
        
      self::delete();
      }
}
