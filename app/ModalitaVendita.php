<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModalitaVendita extends Model
{
    
    protected $table = 'tblModalitaVendita';
    
    protected $guarded = ['id'];



    public function righeConteggio()
    {
        return $this->hasMany('App\RigaConteggio', 'modalita_id', 'id');
    }

    public function commerciali()
    {
        return $this->belongsToMany('App\User', 'tblCommercialeModalitaVendita', 'modalita_id', 'user_id')->withPivot('percentuale');
    }

     
}
