<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GruppoServiziFoglio extends Model
{
    protected $table = 'tblGruppiServiziFoglio';

    protected $guarded = ['id'];


    
    public function elenco_servizi()
    {
        return $this->hasMany('App\ServizioFoglio', 'gruppo_id', 'id');
    }


}
