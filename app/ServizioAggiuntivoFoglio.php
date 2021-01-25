<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServizioAggiuntivoFoglio extends Model
{
    protected $table = 'tblServiziAggiuntiviFoglio';

    protected $guarded = ['id'];


    public function gruppo()
    {
        return $this->belongsTo('App\GruppoServiziFoglio', 'gruppo_id', 'id');
    }

    public function foglio_servizi()
    {
        return $this->belongsTo('App\FoglioServizi', 'foglio_id', 'id');
    }
}
