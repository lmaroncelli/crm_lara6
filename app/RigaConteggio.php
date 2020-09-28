<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RigaConteggio extends Model
{
    protected $table = 'tblRigheConteggi';

    protected $guarded = ['id'];

    public function conteggio()
    {
        return $this->belongsTo('App\Conteggio', 'conteggio_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'cliente_id', 'id');
    }
}
