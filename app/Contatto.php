<?php

namespace App;

use App\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Contatto extends Model
{
   protected $table = 'tblContatti';

   protected $guarded = ['id'];



   public function clienti()
   {
       return $this->belongsToMany(Cliente::class, 'tblClienteContatto', 'contatto_id', 'cliente_id');
   }

   public function clientiIds()
    {
        return $this->clienti->pluck('id')->toArray();
    }


   public function viewColumns()
    {
    $colonneVisibili = [];
    foreach (Schema::getColumnListing($this->table) as $colonna) 
      {
      if(!in_array($colonna, ['id','created_at','updated_at','fea_doc']))
        {
        $colonneVisibili[] = $colonna;
        }
      }
    return $colonneVisibili;
    }

}
