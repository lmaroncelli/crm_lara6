<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Conteggio extends Model
{
    protected $table = 'tblConteggi';

    protected $guarded = ['id'];


    public function commerciale()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function righe()
    {
        return $this->hasMany('App\RigaConteggio', 'conteggio_id', 'id');
    }
 
}
