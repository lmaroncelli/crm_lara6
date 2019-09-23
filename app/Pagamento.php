<?php

namespace App;

use App\Fattura;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
   protected $table = 'tblPagamenti';

   protected $guarded = ['id'];


   public function fatture()
   {
       return $this->hasMany(Fattura::class, 'pagamento_id', 'cod');
   }
   

}
