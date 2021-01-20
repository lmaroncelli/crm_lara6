<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CentroBenessere extends Model
{
    protected $table = 'tblCentroBenessere';

    protected $guarded = ['id'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];



    public function foglioServizi()
    {
        return $this->belongsTo(FoglioServizi::class, 'foglio_id', 'id');
    }
}
