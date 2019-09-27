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

  #IP a cui sono visibili i dettagli di debug (query ed altre info)
	private static $ip_debug = ['127.0.0.1', '2.224.168.43'];


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



}
