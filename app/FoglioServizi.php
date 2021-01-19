<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoglioServizi extends Model
{
    protected $table = 'tblServiziHotel';

    protected $guarded = ['id'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'data_creazione',
        'data_firma'
    ];


    public function commerciale()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'cliente_id', 'id');
    }

    public function infoPiscina()
    {
        return $this->hasOne('App\InfoPiscina', 'foglio_id', 'id');
    }


}
