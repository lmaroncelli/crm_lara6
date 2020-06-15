<?php

namespace App;

use App\Fattura;
use Illuminate\Database\Eloquent\Model;

class AvvisiFattura extends Model
{
    protected $table = 'tblAvvisiFatture';

    protected $dates = [
        'data'
   		];



	  public function fattura()
	  	{
	   	return $this->belongsTo(Fattura::class, 'fattura_id', 'id');
	  	}

}



