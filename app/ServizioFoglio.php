<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServizioFoglio extends Model
{
    protected $table = 'tblServiziFoglio';

    protected $guarded = ['id'];




    public function gruppo()
    {
        return $this->belongsTo('App\GruppoServiziFoglio', 'gruppo_id', 'id');
    }


    public function fogliServizi()
    {
        return $this->belongsToMany('App\FoglioServizi', 'tblFoglioAssociaServizi', 'servizio_id', 'foglio_id');
    }

}
