<?php

namespace App;

use App\Societa;
use App\Contatto;
use App\Localita;
use App\Servizio;
use App\Contratto;
use App\SlotVetrina;
use App\ServizioFoto;
use App\GruppoCliente;
use App\CategoriaCliente;
use App\TipologiaCliente;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
   protected $table = 'tblClienti';

   protected $guarded = ['id'];


   /**
        * The attributes that should be mutated to dates.
        *
        * @var array
        */
       protected $dates = [
           'created_at',
           'updated_at',
           'deleted_at',
           'data_attivazione',
          'data_attivazione_IA',
          'data_disattivazione',
          'data_disattivazione_IA'
       ];


   public function visibile_a_commerciali()
    {
        return $this->belongsToMany('App\User', 'tblClienteVisibileCommerciale', 'cliente_id', 'user_id');
    }

   public function associato_a_commerciali()
    {
        return $this->belongsToMany('App\User', 'tblClienteAssociatoCommerciale', 'cliente_id', 'user_id');
    }

  public function commercialiAssociatiIds()
    {
        return $this->associato_a_commerciali->pluck('id')->toArray();
    }

  public function commercialiVisibilitaIds()
    {
        return $this->visibile_a_commerciali->pluck('id')->toArray();
    }

    public function gruppo()
    {
        return $this->belongsTo(GruppoCliente::class, 'gruppo_id', 'id');
    }

    public function localita()
    {
        return $this->belongsTo(Localita::class, 'localita_id', 'id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipologiaCliente::class, 'tipo_id', 'id');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaCliente::class, 'categoria_id', 'id');
    }

    public function contatti()
    {
        return $this->belongsToMany(Contatto::class, 'tblClienteContatto', 'cliente_id', 'contatto_id');
    }


    public function societa()
    {
        return $this->hasMany(Societa::class, 'cliente_id', 'id');
    }

    public function servizi()
    {
        return $this->hasMany(Servizio::class, 'cliente_id', 'id');
    }


    public function contrattiDigitali()
    {
        return $this->hasMany('App\ContrattoDigitale', 'cliente_id', 'id');
    }

    public function contrattiDigitaliAll()
    {
      return $this->hasMany('App\ContrattoDigitale', 'cliente_id', 'id')->withoutGlobalScope('data_creazione');
    }


    public function fogliServizi()
    {
      return $this->hasMany('App\FoglioServizi', 'cliente_id', 'id');
    }


    ////////////////////////////////////////////////////////////////////////
    // servizi da fatturare per un cliente NON archiviato e SENZA fattura //
    ////////////////////////////////////////////////////////////////////////
    public function servizi_non_fatturati()
    {
        return $this->hasMany(Servizio::class, 'cliente_id', 'id')->where('archiviato',0)->where('fattura_id',NULL);
    }


    public function servizi_attivi()
    {
        return $this->hasMany(Servizio::class, 'cliente_id', 'id')->where('attivo',1)->where('archiviato',0);
    }


    public function contratti()
    {
        return $this->hasMany(Contratto::class, 'cliente_id', 'id');
    }


    public function servizi_foto()
    {
        return $this->hasMany(ServizioFoto::class, 'cliente_id', 'id');
    }

    public function slotVetrina()
    {
        return $this->hasOne(SlotVetrina::class, 'cliente_id', 'id');
    }



    public function scopeAttivo($query)
     {
         return $query->where('attivo',1);
     }

    public function scopeAttivoIA($query)
     {
         return $query->where('attivo_IA',1);
     }


    
    public function scopeOfMacro($query,$macro_id = 0)
    {
      // se ci sono le macro Fiere e Parchi considero tutti i clienti e quindi non filtro !!
      if ($macro_id <= 0) 
        {
          return $query;
        }
      
      $macro = MacroLocalita::find($macro_id);

      $localita_ids = $macro->localita->pluck('id')->toArray();
      

       return $query->whereIn('localita_id',$localita_ids);
      
    }

    public function scopeByIdInfo($query, $id_info = 0)
    {
      if (!$id_info) 
        {
          return $query;
        }
 
       return $query->where('id_info',$id_info);
      
    }




    /**
     * [_getClienteEagerLoaded Uso $orderby SOLO per fare i vari join]
     * @param  [type] $orderby [description]
     * @return [type]          [description]
     */
    public static function getClienteEagerLoaded($orderby)
      {
      $clienti = self::with([
            'localita',
            'associato_a_commerciali',
            'categoria',
            'localita.comune.provincia.regione',
            'contatti',
            'gruppo.clienti',
            ]);
      
      if($orderby == 'nome_localita')
        {
        $clienti->select('tblClienti.*', 'tblLocalita.nome as nome_localita');
        $clienti->join("tblLocalita","tblClienti.localita_id","=","tblLocalita.id");
        }
      elseif ($orderby == 'categoria_id') 
        {
        $clienti->where('categoria_id', '!=', 0);
        }

      return $clienti;
      }


    public function stato($icon = false)
      {
      if ($this->attivo) 
        {
        if ($icon) 
          {
          return '<i class="fa fa-thumbs-up"></i>';
          } 
        else 
          {  
          return "Sì";
          }
        } 
      else 
        {
        if ($icon) 
          {
          return '<i class="fa fa-thumbs-down" style="color:#d42020"></i>';
          } 
        else 
          {
          return "No";
          }
        }
      }

    /**
     * [commerciali scrive i nomi dei commerciali ASSOCIATI a questo cliente ]
     * @return [type] [description]
     */
    public function commerciali()
      {

      $comm = [];

      foreach ($this->associato_a_commerciali as $c) 
        {
        $comm[] = $c->name;
        }
      
      return implode(', ',$comm);

      }
      

}
