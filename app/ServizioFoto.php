<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServizioFoto extends Model
{
    protected $table = 'tblServiziFoto';

    protected $guarded = ['id'];


    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'cliente_id', 'id');
    }
 
}
