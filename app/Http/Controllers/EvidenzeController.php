<?php

namespace App\Http\Controllers;

use App\User;
use App\Cliente;
use App\Utility;
use App\Evidenza;
use App\TipoEvidenza;
use App\MacroLocalita;
use Illuminate\Http\Request;
use App\Http\Controllers\MyController;
use App\ServizioDigitale;

class EvidenzeController extends MyController
{
    public function index(Request $request, $macro_id = 0) 
      {
        
        $macro = MacroLocalita::orderBy('ordine')->pluck('nome','id');
        
        $macro['-1'] = 'Parchi'; 
        $macro['-2'] = 'Offerte Fiera'; 

        $utenti_commerciali = User::commerciale()->orderBy('name')->get();


        $commerciali = $utenti_commerciali->pluck('name','id');

        $tipi_evidenza = TipoEvidenza::with(['macroLocalita','mesi','evidenze','evidenze.mesi'])->ofMacro($macro_id)->get(); 

        // preparo un array tale che $clienti_to_info[id] = id_info senza dover fare sempre la query per ogni cella
        // dovrei filtrare per macrolocalita
        // scopeOfMacro($id_macro) x i clienti ??
        $clienti_to_info = Cliente::attivo()->ofMacro($macro_id)->pluck('id_info','id')->toArray();
        $clienti_to_info[-1] = '';
        $clienti_to_info[0] = '';


        // preparo un array tale che $commerciale_nome[id_utente] = username senza dover fare sempre la query per ogni cella
        $commerciali_nome = $utenti_commerciali->pluck('username','id')->toArray();
        $commerciali_nome[0] = '';


        // preparo i dati per l'autocomplete della selezione hotel
        // deve essere una stringa del tipo ["ID-nome","ID-nome",..] 
        $clienti_autocomplete_js = Utility::getAutocompleteJs($macro_id);

        return view('evidenze.griglia', compact('macro', 'macro_id','tipi_evidenza','clienti_to_info','commerciali','commerciali_nome','clienti_autocomplete_js'));
      }

    public function SelezionaClienteEvidenzeAjax(Request $request)
      {
        $id_macro = $request->get('macro_id');

        // nella forma 1421 - Hotel Fantasy - Rimini
        $item = $request->get('item');

        list($id_info, $name) = explode("-", $item);

        $cliente = Cliente::byIdInfo($id_info)->first();

        $agente = $cliente->associato_a_commerciali()->first();

        if (!is_null($agente)) 
          {
          # metto in sessione 
          session([
            'id_cliente' => $cliente->id,
            'id_info' => $id_info,
            'id_agente' => $agente->id,
            'nome_cliente' => $cliente->nome,
            'nome_agente' => $agente->name,
            'id_macro' => $id_macro
            ]);
          

          echo 'ok';
          } 
        else 
          {
          echo "Nessun id per il commerciale del cliente!!";
          }
        
      }

    public function AssegnaMeseEvidenzaAjax(Request $request)
      {
      $id_agente = $request->get('id_agente');
      $id_cliente = $request->get('id_cliente');
      $id_evidenza = $request->get('id_evidenza');
      $id_mese = $request->get('id_mese');

      $evidenza = Evidenza::find($id_evidenza);

      $ev_mese = $evidenza->mesi->where('numero',$id_mese)->first();
      
      // se NON E' acquistata
      if (!$ev_mese->pivot->acquistata) 
        {
        
        // If you need to update an existing row in your pivot table, you may use updateExistingPivot method
        if ($ev_mese->pivot->cliente_id && $ev_mese->pivot->user_id) 
          {
          $evidenza->mesi()->updateExistingPivot($id_mese, ['cliente_id' => 0, 'user_id' => 0, 'prelazionata' => 0]);
          } 
        else 
          {
          $evidenza->mesi()->updateExistingPivot($id_mese, ['cliente_id' => $id_cliente, 'user_id' => $id_agente]);
          }
        
        }
      
        echo "ok";

      }



    public function CambiaCliente(Request $request) 
      {
        $id_macro = session('id_macro');

        $request->session()->forget(['id_cliente', 'id_info','id_agente','nome_cliente','nome_agente','id_macro']);

        return redirect("evidenze/".$id_macro);

      }


    public function AcquistaEvidenzaAjax(Request $request) 
      {
      $id_agente = $request->get('id_agente');
      $id_cliente = $request->get('id_cliente');
      $id_evidenza = $request->get('id_evidenza');
      $contratto_id = $request->get('contratto_id');

      $evidenza = Evidenza::find($id_evidenza);

      $anno = $evidenza->mesi()->first()->anno;

      $tipoevidenza = $evidenza->tipo;

      $ev_da_acquistare = $evidenza->mesi
                                ->where('pivot.acquistata',0)
                                ->where('pivot.prelazionata',0)
                                ->where('pivot.cliente_id',$id_cliente)
                                ->where('pivot.user_id',$id_agente)
                                ;

      if ($ev_da_acquistare->count()) 
        {
        // VERIFICA CHE LE EVIDENZE SIANO SEQUENZIALI
        $mese_old = 0;
        $sequenziali = true;

        $mesi_count=1;
        
        $primo_mese = null;
        $ultimo_mese = null;
        $costo_tot = 0;
        
        foreach ($ev_da_acquistare as $evidenza_mese) 
          {
          // devo trovare il costo di qesto tipo di evidenza in questo mese
          $costo_tot += $tipoevidenza->mesi->where('pivot.mese_id', $evidenza_mese->pivot->mese_id)->first()->pivot->costo;

          if($mese_old !=0)
            {
            if( $evidenza_mese->pivot->mese_id != $mese_old + 1) 
              {
              $sequenziali = false;
              break;
              }
            }
          
          if($mesi_count==1)
            {
            $primo_mese = $evidenza_mese->numero;
            $ultimo_mese = $primo_mese;
            }
          else
            {
            $ultimo_mese = $evidenza_mese->numero;
            }
          $mese_old = $evidenza_mese->pivot->mese_id;
          $mesi_count++;
          }

        if(!$sequenziali)
          {
          echo "ATTENZIONE: le evidenze da acquistare devono essere sequenziali!\n Dividere i periodi non sequenziali in acquisti separati.";
          die();
          }



        // creo la riga da inserire nella tabella dei ServiziDigitali
        $dal = '01/'.$primo_mese.'/'.$anno;
        $al = Utility::getUltimoGiornoMese($anno.'/'.$ultimo_mese.'/01').'/'.$ultimo_mese . '/' .$anno;


        $data_servizi_digitali = array (
            'nome' => 'EVIDENZA',
            'localita' => $tipoevidenza->macroLocalita->nome,
            'pagina' => $tipoevidenza->nome,
            'dal' => $dal,
            'al' => $al,
            'qta' => 1,
            'importo' => $costo_tot,
            'contratto_id' => $contratto_id
          );

        $servizio_digitale = ServizioDigitale::create($data_servizi_digitali);

        // Metto le evidddenze come Acquistate e le lego al contratto digitale 
        foreach ($ev_da_acquistare as $evidenza_mese) 
          {
          $evidenza_mese->pivot->acquistata = 1;
          $evidenza_mese->pivot->servizioweb_id = $servizio_digitale->id;

          $evidenza_mese->push();
          }

        echo "ok";
        } 
      else 
        {
        echo "Niente da acquistare !";
        }
      
      }

  public function AnnullaAcquistoEvidenzaAjax(Request $request) 
    {
      $id_evidenza = $request->get('id_evidenza');
      $id_mese = $request->get('id_mese');

      $evidenza = Evidenza::find($id_evidenza);

      $evidenza->mesi()->updateExistingPivot($id_mese, ['cliente_id' => 0, 'user_id' => 0, 'prelazionata' => 0, 'acquistata' => 0]);

      echo "ok";

    }


  public function PrelazionaEvidenzaAjax(Request $request) 
    {
    $id_agente = $request->get('id_agente');
    $id_cliente = $request->get('id_cliente');
    $id_evidenza = $request->get('id_evidenza');
    $id_foglio_servizi = $request->get('id_foglio_servizi');

    $evidenza = Evidenza::find($id_evidenza);


    $ev_da_prelazionare = $evidenza->mesi->where('pivot.cliente_id',$id_cliente)->where('pivot.user_id',$id_agente)->where('pivot.acquistata',0)->where('pivot.prelazionata',0);

    if ($ev_da_prelazionare->count()) 
      {
      foreach ($ev_da_prelazionare as $evidenza_mese) 
        {
        $evidenza_mese->pivot->prelazionata = 1;
        $evidenza_mese->push();
        }

      echo "ok";
      } 
    else 
      {
      echo "Niente da prelazionare !";
      }
      
    }

  public function DisassociaMeseEvidenzaPrelazioneAjax(Request $request) 
    {
      $id_evidenza = $request->get('id_evidenza');
      $id_mese = $request->get('id_mese');

      $evidenza = Evidenza::find($id_evidenza);

      $evidenza->mesi()->updateExistingPivot($id_mese, ['cliente_id' => 0, 'user_id' => 0, 'prelazionata' => 0]);

      echo "ok";
    }

    public function AssegnaCostoTipoEvidenzaMeseAjax(Request $request) 
    {
      /**
       dd($request->all());
      array:3 [
        "name" => null
        "value" => "807"
        "pk" => "1 | 2"
      ]
     */
    
    $costo = $request->get('value');
    

    $pk = $request->get('pk');

    list($id_tipo_evidenza,$id_mese) = explode('|',$pk);

    $tipo_evidenza = TipoEvidenza::find($id_tipo_evidenza);
   
    

    // se il costo è empty devo metterlo -1 sul DB
    if(empty($costo))
      {
      $tipo_evidenza->mesi()->updateExistingPivot($id_mese, ['costo' => -1]);
      return response('ok', 200);
      }
    else 
      {
      $costo = ltrim($costo,'0');
      }


    if(!is_numeric($costo))
    {
      $costo = -1;
    }

    try 
      {
      if ($costo == -1) 
        {
        return response('', 400);
        } 
      else 
        {
        // aggiorno il costo nella tabelle tblEVTipiEvidenzeMesi
        $tipo_evidenza->mesi()->updateExistingPivot($id_mese, ['costo' => $costo]);
        return response('ok', 200);
        }
      
      } 
    catch (\Exception $e) 
      {
       return response($e->getMessage(), 400);
      }

    }

}
