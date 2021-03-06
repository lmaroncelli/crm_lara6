<?php

namespace App;

use App\Societa;
use App\Utility;
use App\Pagamento;
use Carbon\Carbon;
use App\AvvisiFattura;
use App\RigaDiFatturazione;
use App\Scopes\FatturaCommercialeScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Fattura extends Model
{
   protected $table = 'tblFatture';

   protected $fillable = ['tipo_id','numero_fattura','data','societa_id','pagamento_id'];

   protected $dates = [
       'created_at',
       'updated_at',
        'data',
   ];




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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('data', function (Builder $builder) {
            $builder->where('data', '>',  Carbon::today()->subYears(1)->toDateString());
        });

        static::addGlobalScope(new FatturaCommercialeScope);
    }



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
      return $this->hasMany(ScadenzaFattura::class, 'fattura_id', 'id')->orderBy('data_scadenza','asc');
   }


   public function scadenze_da_pagare()
   {
      return $this->hasMany(ScadenzaFattura::class, 'fattura_id', 'id')->where('pagata',0)->count();
   }


   public function avvisi()
   {
      return $this->hasMany(AvvisiFattura::class, 'fattura_id', 'id');
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



    public function getTipo()
			{
			return Utility::getNomeTipoFattura($this->tipo_id);
			}

		public function getNumero()
			{
			return $this->numero_fattura;
			}

		public function getDataFattura()
			{
			return $this->data->format('d/m/Y');
			}

		public function getSocietaNome()
			{
			return optional(optional($this->societa)->ragioneSociale)->nome;
			}
		
		public function getSocietaIndirizzo()
			{
			return optional(optional($this->societa)->ragioneSociale)->indirizzo;
			}
		
		public function getCap()
			{
			return optional(optional($this->societa)->ragioneSociale)->cap;
			}
		
		public function getLocalita()
			{
			return optional(optional(optional($this->societa)->ragioneSociale)->localita)->nome;
			}
		
		public function getSiglaProv()
			{
			return optional(optional(optional($this->societa)->ragioneSociale)->localita)->comune->provincia->sigla;
			}
		
		public function getPiva()
			{
			return optional(optional($this->societa)->ragioneSociale)->piva;
			}

		public function getCf()
			{
			return optional(optional($this->societa)->ragioneSociale)->cf;
			}

		public function getSdi()
			{
			return optional(optional($this->societa)->ragioneSociale)->codice_sdi;
			}






    /**
     * [_getClienteEagerLoaded Uso $orderby SOLO per fare i vari join]
     * @param  [type] $orderby [description]
     * @return [type]          [description]
     */
    public static function getFattureEagerLoaded($tipo= 'F', $orderby)
      {
      $fatture = self::with(
                    [
                      'pagamento',
                      'societa.ragioneSociale',
                      'societa.cliente',
                      'fatture'
                    ]
                  )
                  ->withCount('fatture')
                  ->tipo($tipo);

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


    public function hasDiscount()
      {
        $sconto = false;

        foreach ($this->righe as $r) {
          if($r->perc_sconto > 0) {
            $sconto = true;
            break;
          }
        }

        return $sconto;
      }




   public function getTotale($save=false)
    {
    $totale = 0.00;

    foreach ($this->righe as $r) 
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


    public function getImportoScadenze()
      {
      $importo_scadenze = 0.00;
      foreach ($this->scadenze as $s) 
        {
        $importo_scadenze += $s->importo;
        }
      
      return $importo_scadenze;
      }


    public function azzeraTotale()
      {
      $this->totale = 0.00;
      }


  // devo togliere dal totale le eventuali righe scadenza
  // quando il saldo è 0 la fattura è chiusa
   public function fatturaChiusa()
     {
      
      
      
      if($this->getTotale() > 0 && $this->getImportoScadenze() > 0)
        {
        // se sono uguali ritorno TRUE
        return ( round($this->getTotale(),2) === round($this->getImportoScadenze(),2) );
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
      
       return round($this->getTotale(),2) - round($this->getImportoScadenze(),2);

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


  public function destroyMe()
    {
      foreach ($this->righe as $row) 
        {
        $row->delete();
        }
      foreach ($this->scadenze as $row) 
        {
        $row->delete();
        }

      // Detach all prefatture from the fattura...
      self::prefatture()->detach();
      
      // Detach all fatture from the prefattura...
      self::fatture()->detach();  


      self::delete();
    }




}
