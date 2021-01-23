<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElencoServiziHotel extends Model
{
    protected $table = 'tblElencoServiziHotel';

    protected $guarded = ['id'];




    public function gruppo()
    {
        return $this->belongsTo('App\ElencoGruppiServiziHotel', 'gruppo_id', 'id');
    }

}
