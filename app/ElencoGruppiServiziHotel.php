<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElencoGruppiServiziHotel extends Model
{
    protected $table = 'tblElencoGruppiServiziHotel';

    protected $guarded = ['id'];


    
    public function elenco_servizi()
    {
        return $this->hasMany('App\ElencoServiziHotel', 'gruppo_id', 'id');
    }


}
