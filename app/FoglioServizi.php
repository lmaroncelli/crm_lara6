<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoglioServizi extends Model
{
    protected $table = 'tblFogliServizi';

    protected $fillable = [
        'nome_hotel','sms','localita','whatsapp','stagione','skype','prezzo_min','prezzo_max','note_organizzazione_matrimoni','pti_anno_prec','note_pf','pf_1','pf_2','pf_3','pf_4','pf_5','pf_6','pf_7','pf_8','pf_9','tipo','categoria', 'tipo_apertura',
        'maggio_1','fiere','pasqua','capodanno','aprile_25','maggio_1','altra_apertura','n_camere','n_app','n_suite','n_letti','h_24','rec_dalle_ore','rec_dalle_minuti','rec_alle_ore','rec_alle_minuti','checkin','checkout','colazione_dalle_ore','colazione_dalle_minuti','colazione_alle_ore','colazione_alle_minuti','pranzo_dalle_ore','pranzo_dalle_minuti','pranzo_alle_ore','pranzo_alle_minuti','cena_dalle_ore','cena_dalle_minuti','cena_alle_ore','cena_alle_minuti','ai','note_ai','pc','note_pc','mp','note_mp','mp_spiaggia','note_mp_spiaggia','bb','note_bb','bb_spiaggia','note_bb_spiaggia','sd','note_sd','sd_spiaggia','note_sd_spiaggia','caparra','altra_caparra','contanti','assegno','carta_credito','bonifico','paypal','bancomat','note_pagamenti','inglese','francese','tedesco','spagnolo','russo','altra_lingua','tipo','apertura','categoria','piscina','benessere','disabili','organizzazione_matrimoni','organizzazione_cresime','organizzazione_comunioni','note_organizzazione_matrimoni','nome_file',
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'data_creazione',
        'data_firma',
        'dal',
        'al'
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

    public function centroBenessere()
    {
        return $this->hasOne('App\CentroBenessere', 'foglio_id', 'id');
    }

    public function servizi()
    {
        return $this->belongsToMany('App\ServizioFoglio', 'tblFoglioAssociaServizi', 'foglio_id', 'servizio_id')->withPivot('note');
    }

    public function servizi_aggiuntivi()
    {
        return $this->hasMany('App\ServizioAggiuntivoFoglio', 'foglio_id', 'id');
    }




    public function getPrezzoMinAttribute($value) {
        return number_format($value, 2, ',', ' ');
    }

    public function getPrezzoMaxAttribute($value)
    {
        return number_format($value, 2, ',', ' ');
    }


    public function setPrezzoMinAttribute($value)
    {
        $this->attributes['prezzo_min'] = str_ireplace(",", ".", $value);
    }

    public function setPrezzoMaxAttribute($value)
    {
        $this->attributes['prezzo_max'] =  str_ireplace(",", ".", $value);
    }


}
