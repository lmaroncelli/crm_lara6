<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GruppoServiziFoglio extends Model
{
    protected $table = 'tblGruppiServiziFoglio';

    protected $guarded = ['id'];


    
    public function elenco_servizi()
    {
        return $this->hasMany('App\ServizioFoglio', 'gruppo_id', 'id')->orderBy('order');
    }

    public function servizi_aggiuntivi()
    {
        return $this->hasMany('App\ServizioAggiuntivoFoglio', 'gruppo_id', 'id');
    }


}
