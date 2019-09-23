<?php

namespace App;

use App\Fattura;
use App\Pagamento;
use App\RigaDiFatturazione;
use App\Societa;
use Illuminate\Database\Eloquent\Model;

class Fattura extends Model
{
   protected $table = 'tblFatture';

   protected $fillable = ['tipo_id','numero_fattura','numero_prefattura','data','societa_id','pagamento_id'];

   protected $dates = [
       'created_at',
       'updated_at',
        'data',
   ];


   public function setDataAttribute($value)
    {
        $this->attributes['data'] = Utility::getCarbonDate($value);
    }


   public function righe()
   {
       return $this->hasMany(RigaDiFatturazione::class, 'fattura_id', 'id');
   }


   public function scadenze()
   {
       return $this->hasMany(ScadenzaFattura::class, 'fattura_id', 'id');
   }


   public function societa()
   {
       return $this->belongsTo(Societa::class, 'societa_id', 'id');
   }

   public function pagamento()
   {
       return $this->belongsTo(Pagamento::class, 'pagamento_id', 'cod');
   }


   public function servizi()
   {
       return $this->hasMany(Servizio::class, 'fattura_id', 'id');
   }



   /**
    * Same Model many to many
    * https://laracasts.com/discuss/channels/eloquent/same-model-many-to-many
    * 
    */
   public function prefatture() {
       return $this->belongsToMany(Fattura::class,'tblFatturePrefatture','fattura_id','prefattura_id');
   }

   public function fatture() {
       return $this->belongsToMany(Fattura::class,'tblFatturePrefatture','prefattura_id','fattura_id');
   }



   /**
      * Override parent boot and Call deleting event
      *
      * @return void
      */
      protected static function boot() 
       {
         parent::boot();

         static::deleting(function($fattura) {
            foreach ($fattura->servizi as $servizio) {
               $servizio->fattura_id = NULL;
               $servizio->rigafatturazione_id = NULL;
               $servizio->save();
            }
            $fattura->righe()->delete();
            $fattura->scadenze()->delete();
         });
       }




    /**
     * [_getClienteEagerLoaded Uso $orderby SOLO per fare i vari join]
     * @param  [type] $orderby [description]
     * @return [type]          [description]
     */
    public static function getFattureEagerLoaded($orderby)
      {
      $fatture = self::with(
                    [
                      'pagamento',
                      'societa.ragioneSociale',
                      'societa.cliente',
                    ]
                  )
                  ->tipo('F');

      if($orderby == 'nome_pagamento')
        {
        $fatture->select('tblFatture.*', 'tblPagamenti.nome as nome_pagamento');
        $fatture->join("tblPagamenti","tblFatture.pagamento_id","=","tblPagamenti.cod");
        }

      if($orderby == 'nome_societa')
        {
        $fatture->select('tblFatture.*', 'tblRagioneSociale.nome as nome_societa');
        $fatture->join("tblSocieta","tblFatture.societa_id","=","tblSocieta.id")->join("tblRagioneSociale","tblSocieta.ragionesociale_id","=","tblRagioneSociale.id");
        }

      if($orderby == 'nome_cliente')
        {
        $fatture->select('tblFatture.*', 'tblClienti.nome as nome_cliente');
        $fatture->join("tblSocieta","tblFatture.societa_id","=","tblSocieta.id")->join("tblClienti","tblSocieta.cliente_id","=","tblClienti.id"); 
        }
      


      return $fatture;
      }




   public function getTotale($save=false)
    {
    $totale = 0;

    foreach (self::righe()->get() as $r) 
      {
      $totale += $r->totale;
      }

    if($save)
      {
      $this->totale = $totale;
      self::save();
      }
    
    return $totale;
    }


    public function azzeraTotale()
      {
      $this->totale = 0.00;
      }


  // devo togliere dal totale le eventuali righe scadenza
  // quando il saldo è 0 la fattura è chiusa
   public function fatturaChiusa()
     {
      $importo_scadenze = 0;
      foreach (self::scadenze()->get() as $s) 
        {
        $importo_scadenze += $s->importo;
        }

      if($this->getTotale() > 0 && $importo_scadenze > 0)
        {
        // se la differenza è 0 ritorno TRUE
        return !($this->getTotale() - $importo_scadenze);
        }
      else
        {
        return false;
        }

      }

    // devo togliere dal totale le eventuali righe scadenza
   // quando il saldo è 0 la fattura è chiusa
    public function getTotalePerChiudere()
      {
       $importo_scadenze = 0;
       foreach (self::scadenze()->get() as $s) 
         {
         $importo_scadenze += $s->importo;
         }

       return $this->getTotale() - $importo_scadenze;

       }

   public function scopeTipo($query, $tipo_id)
     {
        return $query->where($this->table.'.tipo_id', $tipo_id);
     }


  public static function getLastNumber($tipo_id = 'F', $limit = 10)
    {
    $fatture_last = self::where('tipo_id', $tipo_id)->orderBy('data','desc')->limit($limit)->get();

    return $fatture_last;
    }


  /**
   * Per visualizzare la prefattura come checkbox da associare alla fattura
   * @return [type] [description]
   */
  public function getPrefatturaDaAssociare()
    {
      return $this->numero_fattura. ' ' . $this->data->format('d/m/Y'). ' ' .$this->pagamento->nome;
    }




}
