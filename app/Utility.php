<?php
namespace App;

use App\Associazione;
use App\Pagamento;
use App\Provincia;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Mail;

/**
 *
 */
class Utility extends Model
{

	private static $iva = 22;

	private static $idProdottoEvidenza = 59;

  #IP a cui sono visibili i dettagli di debug (query ed altre info)
	private static $ip_debug = ['127.0.0.1', '2.224.168.43'];

	private static $condizioni_pagamento = [
									'RIBA' => '0',
									'ASSEGNO BANCARIO' => '1',
									'BONIFICO' => '2',
									'CONTANTI' => '3',
									'NESSUNO' => '4',
									'GRATUITO' => '5']; 


	private static $servizi_contratto = [
																'INSERIMENTO BASE' => 'INSERIMENTO BASE',
																'VETRINA PRINCIPALE' => 'VETRINA PRINCIPALE',
																'VETRINA LOC. LIMITROFE' => 'VETRINA LOC. LIMITROFE',
																'GREEN BOOKING' => 'GREEN BOOKING',
																'ALTRO' => 'ALTRO',
																'SCONTO GENERICO' => 'SCONTO GENERICO'];


	private static $localita_contratto = [
																'GABICCE' => 'GABICCE',
												        'CATTOLICA' => 'CATTOLICA',
												        'MISANO ADRIATICO' => 'MISANO ADRIATICO',
												        'RICCIONE' => 'RICCIONE',
												        'RIMINI' => 'RIMINI',
												        'BELLARIA-IGEA MARINA' => 'BELLARIA-IGEA MARINA',
												        'CESENATICO' => 'CESENATICO',
												        'CERVIA' => 'CERVIA',
												        'MILANO MARITTIMA' => 'MILANO MARITTIMA',
												        'LIDI RAVENNATI' => 'LIDI RAVENNATI',
												        'RAVENNA' => 'RAVENNA'];
	

	
	private static $localita_limitrofe_contratto = [
																'MIRAMARE DI RIMINI' => 'MIRAMARE DI RIMINI',
																'RIVAZZURRA DI RIMINI' => 'RIVAZZURRA DI RIMINI',
																'MAREBELLO DI RIMINI' => 'MAREBELLO DI RIMINI',
																'BELLARIVA DI RIMINI' => 'BELLARIVA DI RIMINI',
																'MARINA CENTRO' => 'MARINA CENTRO',
																'SAN GIULIANO MARE' => 'SAN GIULIANO MARE',
																'RIVABELLA DI RIMINI' => 'RIVABELLA DI RIMINI',
																'VISERBA DI RIMINI' => 'VISERBA DI RIMINI',
																'VISERBELLA DI RIMINI' => 'VISERBELLA DI RIMINI',
																'TORRE PEDRERA' => 'TORRE PEDRERA'];
											 

	private static $banca_ia = [
			'nome' => "Crédit Agricole Cariparma",
			'cc' => "000046430439",
			'abi' => '06230',
			'cab' => '24221',
			'cin' => 'H',
			'iban' => "IT 41 H 06230 24221 000046430439",
			'intestatario' => "INFO ALBERGHI SRL"
	];


	// FOGLIO SERVIZI

	private static $fs_tipologia = [
			'0' => 'seleziona', 
			'h' => 'Hotel', 
			'r' => 'Residence', 
			'hr' => 'Hotel + Residence'
	];

	private static $hotel_categoria = [
			'0' => 'seleziona', 
			'1' => '&#9733;', 
			'2' => '&#9733;&#9733;', 
			'3' => '&#9733;&#9733;&#9733;', 
			'3Sup' => '&#9733;&#9733;&#9733;Sup', 
			'4' => '&#9733;&#9733;&#9733;&#9733;', 
			'5' => '&#9733;&#9733;&#9733;&#9733;&#9733;'
	];


	private static $hotel_apertura = [
			'0' => 'seleziona', 
			'a' => 'Annuale', 
			's' => 'Stagionale'
	];


	private static $fs_trattamenti_e_note = [

		'ai' => 'all inclusive',
		'note_ai' => 'note_ai',
		'pc' => 'pens. completa',
		'note_pc' => 'note_pc',
		'mp' => 'mezza pensione',
		'note_mp' => 'note_mp',
		'mp_spiaggia' => 'mezza pensione + spiaggia',
		'note_mp_spiaggia' => 'note_mp_spiaggia',
		'bb' => 'bed&breakfast',
		'note_bb' => 'note_bb',
		'bb_spiaggia' => 'bed&breakfast + spiaggia',
		'note_bb_spiaggia' => 'note_bb_spiaggia',
		'sd' => 'solo dormire',
		'note_sd' => 'note_sd',
		'sd_spiaggia' => 'solo dormire + spiaggia',
		'note_sd_spiaggia' => 'note_sd_spiaggia'
	];


	private static $fs_pagamenti = [
		'contanti' => 'contanti' ,
		'assegno' => 'assegno' , 
		'carta_credito' => 'carta di credito' , 
		'bonifico' => 'bonifico' , 
		'paypal' => 'paypal', 
		'bancomat' => 'bancomat' 
	];


	private static $fs_lingue = [
		'inglese' => 'inglese' ,
		'francese' => 'francese' , 
		'tedesco' => 'tedesco' , 
		'spagnolo' => 'spagnolo' , 
		'russo' => 'russo'
	];


	private static $fs_mesi = [
		'1' => 'Gennaio',
		'2' => 'Febbraio',
		'3' => 'Marzo',
		'4' => 'Aprile',
		'5' => 'Maggio',
		'6' => 'Giugno',
		'7' => 'Luglio',
		'8' => 'Agosto',
		'9' => 'Settembre',
		'10' => 'Ottobre',
		'11' => 'Novembre',
		'12' => 'Dicembre',
	];
	
	/**
	 * Prende l'id del visitatore
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	 
	public static function get_client_ip()
	{
		
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	        
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	        
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	        
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	        
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	       
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	        
	    else
	        $ipaddress = 'UNKNOWN';
	        
	    return $ipaddress;
			
	}


	public static function diff_dalle_alle(Carbon $dalle, Carbon $alle)
		{
		$diff = $dalle->diff($alle)->format('%H:%i');
		list($h, $m) = explode(':', $diff);
		if($m == '0')
			{
			$diff .= '0';
			}
		return $diff;
		}


	/**
	 * Accetta una strina nel formato dd/mm/yyyy e la trasforma in un oggetto data Carbon; se la stringa è vuota o malformata restituisce l'oggetto Carbon da $y=0-$m=0-$d=0.
	 * 
	 * @access public
	 * @static
	 * @param string $data_str (default: "")
	 * @return void
	 */
	 
	public static function getCarbonDate($data_str = "")
	{
		try {

			$data_str = trim($data_str);
			if ($data_str == '') {
				$data_carbon = Carbon::createFromDate(0, 0, 0);
			}
			else {
				list($d, $m, $y) = explode('/', $data_str);
				$data_carbon = Carbon::createFromDate($y, $m, $d);
			}


			return $data_carbon;

		} catch (\Exception $e) {

			return Carbon::now();

		}

	}

	/**
	 * Accetta una strina nel formato dd/mm/yyyy H:i e la trasforma in un oggetto data Carbon; se la stringa è vuota o malformata restituisce l'oggetto Carbon da $y=0-$m=0-$d=0.
	 * Carbon::createFromFormat('Y-m-d H', '1975-05-21 22')
	 * @access public
	 * @static
	 * @param string $data_str (default: "")
	 * @return void
	 */
	
	public static function getCarbonDateTime($data_str = "")
	{
		try {

			$data_str = trim($data_str);
			if ($data_str == '') {
				$data_carbon = Carbon::now();
			}
			else {
				list($data, $time) = explode(' ', $data_str);

				list($d, $m, $y) = explode('/', $data);
				list($h, $min) = explode(':', $time);

				$data_carbon = Carbon::createFromFormat('Y-m-d H i', "$y-$m-$d $h $min");
			}


			return $data_carbon;

		} catch (\Exception $e) {

			return Carbon::now();

		}

	}


	public static function createQueryStringSearch($request)
		{
		$query_array = [
		   'ricerca_campo' => $request->get('ricerca_campo'),
		    'q' => $request->get('q'),
		    'cerca_dal' => $request->get('cerca_dal'),
		    'cerca_al' => $request->get('cerca_al'),
		    'associazione_id' => $request->get('associazione_id'),
		    'no_eliminati' => $request->get('no_eliminati'),
		    'anno_filtro' => $request->get('anno_filtro'),
		    ];

		$query_id = DB::table('tblQueryString')->insertGetId(
		      ['query_string' => http_build_query($query_array)]
		      );

		return $query_id;
		
		} 

	public static function addQueryStringToRequest($query_id,&$request)
		{
			$query = DB::table('tblQueryString')->where('id', $query_id)->first();


			$qs_arr = [];

			if (!is_null($query))
			  {
			  parse_str($query->query_string, $qs_arr);
			  }

			$request->request->add($qs_arr);
		}



	public static function getGoogleApiKey() 
		{ 
		return env('GOOGLE_MAPS_GEOCODING_API_KEY'); 
		}



	public static function iPDebug()
	{
		return self::$ip_debug;
	}

	public static function isIpDebug(Request $request)
	{
    $ip = $request->ip();
    return in_array($ip, self::$ip_debug) && env('APP_ENV') !== 'production';
	}



	public static function getAssociazioni()
	  {
	  return ['0' => 'Tutte'] + Associazione::orderBy('nome')->pluck('nome', 'id')->toArray();
	  }

	
	public static function getIva()
		{
		return self::$iva;
		}

	public static function getIdProdottoEvidenza()
		{
		return self::$idProdottoEvidenza;
		}

	 public static function getHoursForView($total_minutes)
	 	{

	 	if (!is_numeric($total_minutes)) 
	 		{
	 		return $total_minutes;
	 		}

	 	$hours = intval($total_minutes/60);

	 	if ($total_minutes%60 == 0) 
	 	  {
	 	  $minutes = '';  
	 	  } 
	 	else 
	 	  {
	 	  $minutes = ' : '. $total_minutes%60;  
	 	  }
	 	

	 	return $hours . $minutes;
	 	}




	 public static function getNomeTipoFattura($tipo_id)
		{
		switch ($tipo_id) 
			{
			case 'F':
				return 'Fattura';
				break;

			case 'PF':
				return 'Prefattura';
				break;

			case 'NC':
				return 'Nota di credito';
				break;
			
			default:
				return 'Fattura';
				break;
			}
		}

	public static function getPagamentoFattura($pagamento_id)
		{
		return Pagamento::where('cod',$pagamento_id)->first()->nome;
		}

	public static function formatta_cifra($cifra, $simbolo = '')
		{
	
		$formato =  number_format((float)$cifra, 2, ',', '.');
		return empty($simbolo) ? $formato : $simbolo.' '.$formato;
		}



	/**
	 * [isLocalitaInRSM verifica se la località è di San Marino]
	 * @param  [type]  $localita_id [description]
	 * @return boolean              [description]
	 */
	public static function isLocalitaInRSM($localita_id)
		{
			$p_rsm = Provincia::where('sigla','SM')->first();
			$comuni_rsm_ids = $p_rsm->comuni->pluck('id')->toArray();

			// se è 0 NON è SAN MARINO
			return Localita::where('id',$localita_id)->whereIn('comune_id', $comuni_rsm_ids)->get()->count();

    }
    

  public static function breadcrumb($bread = [])
    {
      $to_return = '';

      if (count($bread)) 
        {
    
        $to_return .= '<nav aria-label="breadcrumb">
          <ol class="breadcrumb">';
            $last = end($bread);
            foreach ($bread as $url  => $nome) 
              {
              if($last == $nome)
                {
                $to_return .=  '<li class="breadcrumb-item active" aria-current="page">'.$nome.'</li>';
                }
              else
                {
                $to_return .=  '<li class="breadcrumb-item"><a href="'.$url.'">'.$nome.'</a></li>';
                }
              }
        $to_return .= '</ol>
        </nav>';
        
      }

    return $to_return;
    }



  public static function getAutocompleteJs($macro_id = 0)
    {
      if ($macro_id) 
        {
        $clienti = Cliente::with('localita')->attivo()->ofMacro($macro_id)->get();
        } 
      else 
        {
        $clienti = Cliente::with('localita')->attivo()->get();
        }
      
      $autocomplete = [];
      
      foreach ($clienti as $c) 
        {
        $autocomplete[] = '"'. $c->id_info . ' - ' . addslashes($c->nome) . ' - ' . addslashes($c->localita->nome). '"';
        }
      
      return "[" . implode(',', $autocomplete) . "]";
      
    }


	public static function getCondizioniPagamento()
		{
		return self::$condizioni_pagamento;
		}


	public static function getServiziContratto()
		{
		return self::$servizi_contratto;
		}


	public static function getLocalitaContratto()
		{
		return self::$localita_contratto;
		}


	public static function getLocalitaLimitrofeContratto()
		{
		return self::$localita_limitrofe_contratto;
		}
		

	public static function getBancaIa()
		{
		return self::$banca_ia;
		}


	public static function getFsTipologia()
	{
	return self::$fs_tipologia;
	}



	public static function getFsMinuti()
	{
		$minuti['00'] = '00';
		$minuti['15'] = '15';
		$minuti['30'] = '30';
		$minuti['45'] = '45';

		return $minuti; 
	}


	public static function getFsOre()
	{
		for ($i = 1; $i <= 24; $i++) {
			$ore[$i] = $i;
		}

		return $ore; 
	}


	public static function getFsTrattamentiENote()
	{
		return self::$fs_trattamenti_e_note;
	}




	public static function getHotelCategoria()
	{
		return self::$hotel_categoria;
	}

	public static function getHotelApertura()
	{
		return self::$hotel_apertura;
	}


	public static function getFsPagamenti()
	{
		return self::$fs_pagamenti;
	}


	public static function getFsLingue()
	{
		return self::$fs_lingue;
	}

	public static function getFsMesi()
	{
		return self::$fs_mesi;
	}



	public static function getFsPosizionePiscina()
	{
		$posizione['giardino'] = 'giardino';
		$posizione['piano rialzato'] = 'piano rialzato';
		$posizione['panoramica sul tetto'] = 'panoramica sul tetto';
		$posizione['in spiaggia'] = 'in spiaggia';
		$posizione['interna'] = 'interna';
		$posizione['interna ed esterna'] = 'interna ed esterna';

		return $posizione;
	}

	public static function getFsCaratteristichePiscina()
	{
		$carr['coperta'] = 'coperta';
		$carr['riscaldata'] = 'riscaldata';
		$carr['salata'] = 'salata';
		$carr['idro'] = 'idromassaggio';
		$carr['idro_cervicale'] = 'idromass. cervicale';
		$carr['scivoli'] = 'scivoli';
		$carr['trampolino'] = 'trampolino';
		$carr['aperitivi'] = 'aperitivi in piscina';
		$carr['getto_bolle'] = 'getto di bolle';
		$carr['cascata'] = 'cascata d\'acqua';
		$carr['musica_sub'] = 'musica subacquea';
		$carr['wi_fi'] = 'zona wi-fi';
		$carr['pagamento'] = 'a pagamento';
		$carr['salvataggio'] = 'bagnino di salvataggio';
		$carr['nuoto_contro'] = 'nuoto controcorrente';


		return $carr;
	}

	public static function getFsCaratteristicheCentroBenessere()
	{

		$carr['piscina_benessere'] = 'piscina';
		$carr['idromassaggio'] = 'idromassaggio';
		$carr['sauna_finlandese'] = 'sauna finlandese';
		$carr['bagno_turco'] = 'bagno turco';
		$carr['docce_emozionali'] = 'docce emozionali';
		$carr['cascate_ghiaccio'] = 'cascate di ghiaccio';
		$carr['aromaterapia'] = 'aromaterapia';
		$carr['percorso_kneipp'] = 'percorso kneipp';
		$carr['cromoterapia'] = 'cromoterapia';
		$carr['massaggi'] = 'massaggi';
		$carr['trattamenti_estetici'] = 'trattamenti estetici';
		$carr['area_relax'] = 'area relax';
		$carr['letto_marmo_riscaldato'] = 'letto di marmo riscaldato';
		$carr['stanza_sale'] = 'stanza del sale';
		$carr['kit_benessere'] = 'kit benessere in dotazione';

		return $carr;
	}


	public static function getFsPosizioneVasca()
	{
		$posizione['giardino'] = 'giardino';
		$posizione['piano rialzato'] = 'piano rialzato';
		$posizione['panoramica sul tetto'] = 'panoramica sul tetto';
		$posizione['in spiaggia'] = 'in spiaggia';
		$posizione['interna'] = 'interna';
		$posizione['esterna'] = 'esterna';

		return $posizione;
	}



	public static function getUltimoGiornoMese($data = '')
		{
		
		return date('t', strtotime($data));
		}



	public static function onlyAlpha($s)
		{
		$result = preg_replace("/[^a-zA-Z0-9\s\-,]+/", "", $s);
		return $result;
		} 


}
