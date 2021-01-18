<?php

namespace App;

use App\Conteggio;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    

    public function clienti_visibili()
    {
        return $this->belongsToMany('App\Cliente', 'tblClienteVisibileCommerciale', 'user_id', 'cliente_id');
    }


    public function clienti_associati()
    {
        return $this->belongsToMany('App\Cliente', 'tblClienteAssociatoCommerciale', 'user_id', 'cliente_id')->orderBy('nome','asc');
    }


    public function clientiAssociatiIds()
    {
        return $this->clienti_associati->pluck('id')->toArray();
    }

    public function contrattiDigitali()
    {
        return $this->hasMany('App\ContrattoDigitale', 'user_id', 'id');
    }


    public function fogliServizi()
    {
        return $this->hasMany('App\FoglioServizi', 'user_id', 'id');
    }

    public function conteggi()
    {
        return $this->hasMany('App\Conteggio', 'user_id', 'id');
    }

    public function conteggi_terminati()
    {
        return $this->hasMany('App\Conteggio', 'user_id', 'id')->where('terminato',1);
    }


    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user_table', 'user_id', 'role_id');
    }

    public function modalita_vendita()
    {
        return $this->belongsToMany('App\ModalitaVendita', 'tblCommercialeModalitaVendita', 'user_id', 'modalita_id')->withPivot('percentuale');
    }

    public function scopeCommerciale($query)
     {
         return $query->where('type_id','C');
     }

    public function hasType($type)
     {
     return strtolower($type) === strtolower($this->type_id);
     }

     public function getGravatarAttribute()
     {
         $hash = md5( strtolower( trim($this->email) ) );
         return "http://www.gravatar.com/avatar/$hash";
     }

}
