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
		
		public function modalita()
    {
        return $this->belongsTo('App\ModalitaVendita', 'modalita_id', 'id');
    }

    public function servizi()
    {
        return $this->belongsToMany('App\Servizio', 'tblRigaConteggioServizio', 'riga_conteggio_id', 'servizio_id');
    }

    public function getServizi()
			{
			$servizi_arr = [];
			
			foreach ($this->servizi as $servizio) 
				{
				$servizi_arr[] = $servizio->prodotto->nome;
				}

			return implode(',', $servizi_arr);
			}
}
