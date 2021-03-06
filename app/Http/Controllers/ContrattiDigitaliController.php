<?php

namespace App\Http\Controllers;


use PDF;
use App\User;
use App\Cliente;
use App\Societa;
use App\Utility;
use SignatureField;
use App\TipoEvidenza;
use App\MacroLocalita;
use App\RagioneSociale;
use App\ServizioDigitale;
use App\ContrattoDigitale;
use SetaPDF_Core_Document;
use Illuminate\Http\Request;
use SetaPDF_Core_Reader_File;
use SetaPDF_Core_Writer_File;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MyController;
use App\Localita;
use Illuminate\Support\Facades\Storage;

class ContrattiDigitaliController extends MyController
{

  //require_once('path/to/library/SetaPDF/Autoload.php');


    private function _gestione_iban(&$i1="", &$i2="", &$i3="", &$i4="", &$mostra_iban_importato=0, $contratto)
      {
      if($contratto->iban != '' && count(explode(' ',$contratto->iban)) == 4)
        {
        list($i1,$i2,$i3,$i4) = explode(' ',$contratto->iban);
        $mostra_iban_importato = 0;
        }
      else
        {
        if ($contratto->id_cliente == -1) 
          {
          $mostra_iban_importato = 0;
          } 
        else 
          {
          $mostra_iban_importato = 1;
          }
        
        }
      }


    private function _servizi_associati($contratto)
      {
      return [];
      }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $all = null)
    {

      // campo libero
      $qf = $request->get('qf');
      $field = $request->get('field');

      $orderby = $request->get('orderby');
      $order = $request->get('order');


      if(is_null($order))
      {
        $order='desc';
      }

    if(is_null($orderby))
      {
        $orderby='id';
      }

      if ( !is_null($all) && $all == 'all' )
        {
        $url_index = 'contratto-digitale/all';
        $precontratti = ContrattoDigitale::withoutGlobalScope('data_creazione')->with(['commerciale','cliente'])->withCount('servizi');
        $all = 1;
        } 
      else 
        {
        $url_index = 'contratto-digitale';
        $precontratti = ContrattoDigitale::with(['commerciale','cliente'])->withCount('servizi');
        $all = 0;  
        }

      $join_users = 0;
      $join_clienti = 0;

      if( !is_null($qf) && $field != '0' )
       {
        if($field == 'commerciale')
          {
            $precontratti = $precontratti
            ->select(DB::raw('tblContrattiDigitali.*, users.name as nome_commerciale'))
            ->join('users', 'users.id', '=', 'tblContrattiDigitali.user_id')
            ->with([
              'commerciale',
              'cliente'
              ])
            ->withCount('servizi')
            ->where('users.name','LIKE','%'.$qf.'%');
            

            $join_users = 1;

          }
        elseif($field == 'cliente') 
          {
            $precontratti = $precontratti
            ->select(DB::raw('tblContrattiDigitali.*, tblClienti.nome as nome_cliente'))
            ->join('tblClienti', 'tblClienti.id', '=', 'tblContrattiDigitali.cliente_id')
            ->with([
              'commerciale',
              'cliente'
              ])
            ->withCount('servizi')
            ->where('tblClienti.nome','LIKE','%'.$qf.'%');

            $join_clienti = 1;
          }
       }

      if ($orderby == 'nome_commerciale' && !$join_users) 
        {
          $precontratti = $precontratti
          ->select(DB::raw('tblContrattiDigitali.*, users.name as nome_commerciale'))
          ->join('users', 'users.id', '=', 'tblContrattiDigitali.user_id')
          ->with([
            'commerciale',
            'cliente'
            ])
          ->withCount('servizi');
        } 
      elseif($orderby == 'nome_cliente' && !$join_clienti)
        {
          $precontratti = $precontratti
          ->select(DB::raw('tblContrattiDigitali.*, tblClienti.nome as nome_cliente'))
          ->join('tblClienti', 'tblClienti.id', '=', 'tblContrattiDigitali.cliente_id')
          ->with([
            'commerciale',
            'cliente'
            ])
          ->withCount('servizi');
        }

      $precontratti = $precontratti->orderBy($orderby, $order);
      
      $to_append = ['order' => $order, 'orderby' => $orderby];

      if( !is_null($qf) && $field != '0' )
       {
       $to_append['qf'] = $qf;
       $to_append['field'] = $field;
       }

      
      $precontratti = $precontratti->paginate(15)->setpath('')->appends($to_append);

      $campi_precontratti_search[] = 'campo in cui cercare';
      $campi_precontratti_search['commerciale'] = 'commerciale';
      $campi_precontratti_search['cliente'] = 'cliente';

      return view('contratti_digitali.index', compact('precontratti','campi_precontratti_search','url_index','all'));
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $clienti_autocomplete_js = Utility::getAutocompleteJs();

      $utenti_commerciali = User::commerciale()->orderBy('name')->get();

      return view('contratti_digitali.form_init', compact('clienti_autocomplete_js', 'utenti_commerciali'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
      {
    
      // $validation_arr = ['fatturazione' => 'required', 'referente' => 'required'];
      
      // $validatedData = $request->validate($validation_arr);
      
      //dd($request->all());


      // E' un CLIENTE ESISTENTE
      if ($request->has('item') && $request->get('item') != '') 
        {
        $item = $request->get('item');
        list($id_info, $name) = explode("-", $item);

        $cliente = Cliente::with('localita')->byIdInfo($id_info)->first();
        $dati_cliente = $cliente->id_info . ' - ' .$cliente->nome."\n".$cliente->localita->nome;

        $cliente_id = $cliente->id;


        $rag_soc = RagioneSociale::with('localita.comune.provincia')->find($request->get('fatturazione'));

        $dati_fatturazione = $rag_soc->nome . "\n" .$rag_soc->indirizzo . "\n" . $rag_soc->cap . "-" .$rag_soc->localita->nome .'('. $rag_soc->localita->comune->provincia->sigla .") \nP.IVA: ". $rag_soc->piva . "\nCodice Fiscale: ".$rag_soc->cf;

        $societa = Societa::withRagioneSociale($rag_soc->id)->first();


        $dati_referente = $request->referente;
        
        // IBAN della società può essere già corretto oppure essere malformato
        if($this->_guess_iban($societa->iban))
          {
          $iban = $societa->iban;
          $iban_importato = "" ;
          }
        else
          {
          $iban = "" ;
          $iban_importato = $societa->iban;
          }

          $email = $cliente->email;
          $email_amministrativa = $cliente->email_amministrativa;
          $sito_web = $cliente->web;
  
          $pec = $cliente->pec;
          $codice_destinatario = $cliente->codice_destinatario;





        } 
      else 
        {

        $dati_cliente = $request->get('cliente');
        $cliente_id = -1;
        $dati_fatturazione = $request->get('fatturazione');
        $dati_referente = $request->get('referente');

        $iban = "" ;
        $iban_importato = "";

        $email = "";
        $email_amministrativa = "";
        $sito_web = "";

        $pec = "";
        $codice_destinatario = "";
        

        }
      

         $data = array (
         'user_id' => $request->id_commerciale,
         'cliente_id' => $cliente_id,
         'dati_cliente' => $dati_cliente,
         'data_creazione' => now(),
         'tipo_contratto' => $request->tipo_contratto,
         'segnalatore' => $request->segnalatore,
         'dati_fatturazione' => $dati_fatturazione,
         'dati_referente' => $dati_referente,
         'iban' => $iban,
         'iban_importato' => $iban_importato,
         'pec' => $pec,
         'codice_destinatario' => $codice_destinatario,
         'sito_web' => $sito_web,
         'email' => $email,
         'email_amministrativa' => $email_amministrativa,
         );
         
         
         $contratto = ContrattoDigitale::create($data);

         return redirect()->route('contratto-digitale.edit', $contratto->id);

      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    public function creaGrigliaEvidenzaContrattoAjax(Request $request)
      {
      
      $tipi_evidenza = collect([]);

      $contratto_id = $request->get('contratto_id'); 
      
      // SELEZIONE LOCALITA da NUOVO UTENTE
      if($request->has('localita_id'))
        {
        $localita_id = $request->get('localita_id');
        $macro_id = Localita::find($localita_id)->macrolocalita_id;
        }
      else
        {
        $macro_id = $request->get('macro_id');
        }

      
      $destroy_session = $request->get('destroy_session');
      
      $contratto = ContrattoDigitale::withoutGlobalScope('data_creazione')->with('cliente')->find($contratto_id);
      
      //  IL CONTRATTO PUO' APPARTENERE AD UN CLIENTE GIA' ESISTENTE OPPURE A UNO NUOVO CHE NON ESISTE GIA' NEL CRM
      if ($contratto->cliente_id == -1) 
        {
        $macro = MacroLocalita::orderBy('ordine')->pluck('nome','id');
        } 
      else 
        {
        if(!$macro_id)
          {
          $macro_id = $contratto->cliente->localita->macrolocalita_id;
          }
          $macrolocalita = MacroLocalita::find($macro_id);
          $macro[$macrolocalita->id] = $macrolocalita->nome; 
        }
         
      $macro['-1'] = 'Parchi'; 
      $macro['-2'] = 'Offerte Fiera';

      $tipi_evidenza = TipoEvidenza::with(['macroLocalita','mesi','evidenze','evidenze.mesi'])->ofMacro($macro_id)->get(); 
      

      $utenti_commerciali = User::commerciale()->orderBy('name')->get();
      $commerciali_nome = $utenti_commerciali->pluck('username','id')->toArray();
      $commerciali_nome[0] = '';


      if ($request->session()->has('servizi_venduti_ids') && !$destroy_session) 
        {
        $servizi_venduti_ids = $request->session()->get('servizi_venduti_ids');
        }
      else
        {
          $servizi_venduti_ids = 
          $contratto->servizi()->where('sconto',0)
          ->orWhere(function($query) use ($contratto_id) {
            $query->where('contratto_id',$contratto_id);
            $query->where('sconto',1);
            $query->whereNull('servizio_scontato_id');
          })
          ->pluck('id')->toArray();

          
          session(['servizi_venduti_ids' => $servizi_venduti_ids]);

        }

      if ($request->session()->has('clienti_to_info') && !$destroy_session)
        {
        $clienti_to_info = $request->session()->get('clienti_to_info');
        } 
      else
        {
        $clienti_to_info = Cliente::attivo()->ofMacro($macro_id)->pluck('id_info','id')->toArray();
        $clienti_to_info[-1] = '';
        $clienti_to_info[0] = '';

        session(['clienti_to_info' => $clienti_to_info]);
        }
      
      //dd($macro);

      return view('contratti_digitali.evidenze_contratto',compact('macro', 'contratto', 'tipi_evidenza', 'macro_id','commerciali_nome','servizi_venduti_ids','clienti_to_info'));

      }

    
      public function caricaServiziContrattoAjax(Request $request)
        {
        $contratto_id = $request->get('contratto_id');
        $destroy_session = $request->get('destroy_session');

        $contratto = ContrattoDigitale::withoutGlobalScope('data_creazione')->with('cliente')->find($contratto_id);
        
        //================================================//
        // Servizi associati al contratto
        //================================================//

        //Tutti i sevizi NON SCONTO OPPURE gli sconti GENERICI
          
        if ($request->session()->has('servizi_venduti') && !$destroy_session) 
          {
          $servizi_venduti = $request->session()->get('servizi_venduti');
          }
        else
          {
          $servizi_venduti = 
              $contratto->servizi()->where('sconto',0)
              ->orWhere(function($query) use ($contratto_id) {
                $query->where('contratto_id',$contratto_id);
                $query->where('sconto',1);
                $query->whereNull('servizio_scontato_id');
              })
              ->get();
          
          session(['servizi_venduti' => $servizi_venduti]);
          }
        
        
        
          // tutti gli sconti associati ad un servizio
          if ($request->session()->has('sconti') && !$destroy_session) 
            {
            $sconti = $request->session()->get('sconti');
            }
          else
            {
            $sconti = $contratto->sconti_associati->keyBy('servizio_scontato_id');
            
            session(['sconti' => $sconti]);
            }
        
          
          $servizi_assoc = [];
          $totali = [];
          
          $this->getServiziAssociatiAndTotali($servizi_venduti, $sconti, $servizi_assoc, $totali);


            
          //================================================//
          // Servizi da scegliere 
          //================================================//
     
          if ($request->session()->has('servizi_contratto')) 
            {
            $servizi_contratto = $request->session()->get('servizi_contratto');
            }
          else
            {
            $servizi_contratto = [' ' => 'SELEZIONA....'] + Utility::getServiziContratto();
            session(['servizi_contratto' => $servizi_contratto]);
            }
        
        
          return view('contratti_digitali.servizi_contratto',compact('servizi_assoc', 'servizi_contratto', 'totali', 'contratto'));

      
          //================================================//
          // /Servizi associati al contratto 
          //================================================//
      }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id, $macro_id = 0)
    {
      $contratto = ContrattoDigitale::withoutGlobalScope('data_creazione')->with('cliente')->find($id);
      
      // gestione IBAN
      $this->_gestione_iban($i1, $i2, $i3, $i4, $mostra_iban_importato, $contratto);

     // commerciale selezionato
     $commerciale_contratto = User::find($contratto->user_id)->name;

      // servizi già associati a questo contratto
      $servizi_assoc = $this->_servizi_associati($contratto);

      //condizioni di pagamento
      $condizioni_pagamento = Utility::getCondizioniPagamento();

      $localita_cliente_select = [];


      // GESTIONE GRIGLIA EVIDENZE

      //  IL CONTRATTO PUO' APPARTENERE AD UN CLIENTE GIA' ESISTENTE OPPURE A UNO NUOVO CHE NON ESISTE GIA' NEL CRM
      if ($contratto->cliente_id == -1) 
        {
        $macro = MacroLocalita::orderBy('ordine')->pluck('nome','id');
        $localita_cliente_select = Localita::where('macrolocalita_id','!=',0)->orderBy('nome','asc')->pluck('nome','id')->toArray();
        } 
      else 
        {
        if(!$macro_id)
          {
          $macro_id = $contratto->cliente->localita->macrolocalita_id;

          $macrolocalita = MacroLocalita::find($macro_id);
          $macro[$macrolocalita->id] = $macrolocalita->nome; 
          }
        }
      $macro['-1'] = 'Parchi'; 
      $macro['-2'] = 'Offerte Fiera';

      //==================================================//
      // CODICE COPIATO DA EvidenzeController@index DRY !!!
      // utilizzare un composer ????
      //==================================================//
      
      $utenti_commerciali = User::commerciale()->orderBy('name')->get();
      $commerciali = $utenti_commerciali->pluck('name','id');


      $tipi_evidenza = TipoEvidenza::with(['macroLocalita','mesi','evidenze','evidenze.mesi'])->ofMacro($macro_id)->get(); 

      
      // preparo un array tale che $clienti_to_info[id] = id_info senza dover fare sempre la query per ogni cella
      // dovrei filtrare per macrolocalita
      // scopeOfMacro($id_macro) x i clienti ??
      if ($request->session()->has('clienti_to_info'))
        {
        $clienti_to_info = $request->session()->get('clienti_to_info');
        } 
      else
        {
        $clienti_to_info = Cliente::attivo()->ofMacro($macro_id)->pluck('id_info','id')->toArray();
        $clienti_to_info[-1] = '';
        $clienti_to_info[0] = '';

        session(['clienti_to_info' => $clienti_to_info]);
        }


      

      // preparo un array tale che $commerciale_nome[id_utente] = username senza dover fare sempre la query per ogni cella
      $commerciali_nome = $utenti_commerciali->pluck('username','id')->toArray();
      $commerciali_nome[0] = '';

      //==================================================//
      // CODICE COPIATO DA EvidenzeController@index DRY !!!
      // utilizzare un composer ????
      //==================================================//



    //================================================//
    // Servizi associati al contratto
    //================================================//

      //Tutti i sevizi NON SCONTO OPPURE gli sconti GENERICI
      $servizi_venduti = 
          $contratto->servizi()->where('sconto',0)
          ->orWhere(function($query) use ($id) {
            $query->where('contratto_id',$id);
            $query->where('sconto',1);
            $query->whereNull('servizio_scontato_id');
          })
          ->get();
      
      session(['servizi_venduti' => $servizi_venduti]);
        
      
      
      
      // tutti gli sconti associati ad un servizio
      $sconti = $contratto->sconti_associati->keyBy('servizio_scontato_id');

      session(['sconti' => $sconti]);
    


       
      $servizi_assoc = [];
      $totali = [];
      
      $this->getServiziAssociatiAndTotali($servizi_venduti, $sconti, $servizi_assoc, $totali);
      
      
    
    //================================================//
    // /Servizi associati al contratto 
    //================================================//
    

    
    //================================================//
    // Servizi da scegliere 
    //================================================//
     
    
    $servizi_contratto = [' ' => 'SELEZIONA....'] + Utility::getServiziContratto();
    session(['servizi_contratto' => $servizi_contratto]);
  
    

    //================================================//
    // /Servizi da scegliere 
    //================================================//

    # metto in sessione 
    session([
        'id_cliente' => $contratto->cliente_id,
        'id_info' => optional($contratto->cliente)->id_info,
        'id_agente' => $contratto->user_id,
        'nome_cliente' => '',
        'nome_agente' => '',
        'id_macro' => $macro_id
        ]);
   

    
    $servizi_venduti_ids = $servizi_venduti->pluck('id')->toArray();
    // Quando aggiorno la griglia se non cambiano i servizi li prendo dalla sessione 
    session(['servizi_venduti_ids' => $servizi_venduti_ids]);
     

      $exists = Storage::disk('precontratti')->exists($contratto->nome_file.'_firmato.pdf');

      return view('contratti_digitali.form', compact('contratto','i1','i2','i3','i4', 'mostra_iban_importato', 'commerciale_contratto','servizi_assoc','condizioni_pagamento','tipi_evidenza','clienti_to_info','commerciali_nome','macro','macro_id', 'utenti_commerciali', 'commerciali','totali','servizi_contratto','servizi_venduti_ids','exists','localita_cliente_select'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $validation_array = [
        'dati_cliente' => 'required',
        'dati_fatturazione' => 'required',
        'condizioni_pagamento' => 'required'
      ];


      if($request->has('iban') && $request->iban != '')
        {
        $validation_array['iban'] = 'alpha_num|size:27';
        }

      if($request->has('codice_destinatario') && $request->codice_destinatario != '')
        {
        $validation_array['codice_destinatario'] = 'alpha_num|size:7';
        }

      if($request->has('pec') && $request->pec != '')
        {
        $validation_array['pec'] = 'email:rfc,dns';
        }

      if($request->has('email') && $request->email != '')
        {
        $validation_array['email'] = 'email:rfc,dns';
        }
      
      if($request->has('email_amministrativa') && $request->email_amministrativa != '')
        {
        $validation_array['email_amministrativa'] = 'email:rfc,dns';
        }

        if($request->has('nome_file') && $request->nome_file != '')
        {
        $validation_array['nome_file'] = 'alpha_dash';
        }



      $request->validate($validation_array);

      $request_to_except = ['i1','i2','i3','i4','nome_file_scelto'];
      
      
      $contratto = ContrattoDigitale::withoutGlobalScope('data_creazione')->find($id);


      foreach (Utility::getCondizioniPagamento() as $cp => $value) 
        {
        if($request->has('condizioni_pagamento') && $request->get('condizioni_pagamento') == $cp)
          {
          $data_pagamento = $request->get('data_pagamento_'.$value);
          $contratto->data_pagamento = $data_pagamento;
          }

        $request_to_except[] = 'data_pagamento_'.$value;
        }
      
      $contratto->update($request->except($request_to_except));

      return redirect('contratto-digitale/'.$id.'/edit');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $contratto = ContrattoDigitale::withoutGlobalScope('data_creazione')->find($id);
      $contratto->destroyMe();

      return redirect()->route('contratto-digitale.index')->with('status', 'Precontratto elimnato correttamente!');



    }


    public function LoadFatturazioneContrattoDigitaleAjax(Request $request)
      {
      // nella forma 1421 - Hotel Fantasy - Rimini
      $item = $request->get('item');

      list($id_info, $name) = explode("-", $item);

      $cliente = Cliente::byIdInfo($id_info)->first();

      $rag_soc = [];

      foreach ($cliente->societa as $soc) 
        {
        $rag_soc[] = $soc->ragioneSociale;
        }
      
      return view('contratti_digitali._societa_radio', compact('rag_soc'));
      
      }
    
    public function LoadReferenteContrattoDigitaleAjax(Request $request)
      {
      // nella forma 1421 - Hotel Fantasy - Rimini
      $item = $request->get('item');

      list($id_info, $name) = explode("-", $item);

      $cliente = Cliente::byIdInfo($id_info)->first();
      
      $referenti = [];
      foreach ($cliente->contatti as $contatto) 
        {
        foreach (['ruolo','nome','email','cellulare'] as $field) 
          {
          if($contatto->$field != '')
            {
            $ref[] = $contatto->$field;
            }
          }
        $referenti[] = implode(' ', $ref);
        }

      return view('contratti_digitali._referenti', compact('referenti'));
      
      }

    public function LoadRigaScontoAjax(Request $request)
      {
        $idcontratto = $request->get('idcontratto');  
        $idservizio = $request->get('idservizio');
          
        // trovo il servizio a cui viglio fare lo sconto 
        $servizio = ServizioDigitale::find($idservizio);
              
       return view('contratti_digitali._riga_sconto', compact('idcontratto','servizio'));

      }


    
      public function LoadRigaServizioAjax(Request $request)
        {
        
        $idcontratto = $request->get('idcontratto');  
        
        $servizio = $request->get('servizio');
        
        if ($servizio == "") 
          {
          echo "";
          }
        elseif ($servizio == "ALTRO" || $servizio == "SCONTO GENERICO")
          {
          return view('contratti_digitali._riga_servizio', compact('idcontratto','servizio'));
          }
        elseif ($servizio == "VETRINA LOC. LIMITROFE")
          {
          $localita = ['SELEZIONA' => 'SELEZIONA...'] + Utility::getLocalitaLimitrofeContratto();
          
          return view('contratti_digitali._riga_servizio', compact('idcontratto','servizio','localita'));
          }
        else
          {
          $localita = ['SELEZIONA' => 'SELEZIONA...'] + Utility::getLocalitaContratto();

          return view('contratti_digitali._riga_servizio', compact('idcontratto','servizio','localita'));
          }

        }


    public function DelRigaServizioAjax(Request $request)
      {
      $servizio_id = $request->get('idservizio');
      $contratto_id = $request->get('idcontratto');
      
      if(is_null($servizio_id) || $servizio_id <= 0 || is_null($contratto_id) || $contratto_id <= 0)
        {
        return "ko";
        }
      
      $servizio = ServizioDigitale::find($servizio_id);
      
      if(is_null($servizio) || $servizio->contratto_id != $contratto_id)
        {
        return "Si cerca di eliminare un servizo che non fa parte del contratto in essere";
        }
      
      if($servizio->sconto && !is_null($servizio->servizio_scontato_id)) 
        {
        ServizioDigitale::find($servizio->servizio_scontato_id)->togliSconto();
        }
      else
        {
        // verifico se ha uno sconto associato e lo elimino
        if($servizio->scontato)
          {
          ServizioDigitale::where('servizio_scontato_id',$servizio->id)->delete();
          }

        // cancello i servizi dalle evidenze
        $is_evidenza = DB::table('tblEVEvidenzeMesi')
              ->where('servizioweb_id', $servizio->id)
              ->update(['cliente_id' => 0, 'user_id' => 0, 'acquistata' => 0, 'servizioweb_id' => 0]);
        }
     
      $servizio->delete();


      if ($is_evidenza) 
        {
        return "is_evidenza";
        } 
      else 
        {
        return "NOT_is_evidenza";
        }
      

      }

    
    public function SaveRigaScontoAjax(Request $request)
      {
        $request->validate([
          'importo' => 'required|integer|gt:0',
        ]);

        $nome = $request->get('nome');
        $importo = $request->get('importo');
        $idcontratto = $request->get('idcontratto');
        $idservizio = $request->get('idservizio');

        // inserisco lo sconto
        $data = array (
            'nome' => $nome,
            'importo' => $importo,
            'contratto_id' => $idcontratto,
            'servizio_scontato_id' => $idservizio,
            'sconto' => true,
          );
        
        ServizioDigitale::create($data);
        

        // marco scontato questo servizio
        ServizioDigitale::where('id',$idservizio)->update(['scontato' => true]);

        echo 'ok';


      }

      public function SaveRigaServizioAjax(Request $request)
        {
        
        $servizio = $request->get('servizio');
        $contratto_id = $request->get('idcontratto');
        
        if(is_null($servizio) || is_null($contratto_id))
          {
          echo 'ko';
          }
        elseif($servizio == 'SCONTO GENERICO')
          {
            $validation_array = [
              'sconto' => 'required',
              'importo' => 'required|integer|gt:0',
            ];

            $request->validate($validation_array);

            $data['nome'] = $request->get('sconto'); 
            $data['importo'] = $request->get('importo');
            $data['contratto_id'] = $contratto_id;
            $data['sconto'] = true;

            ServizioDigitale::create($data);
          

            echo 'ok';

          }
        else 
          {
          
          $validation_array = [
            'dal' => 'required|date_format:d/m/Y',
            'al' => 'required|date_format:d/m/Y',
            'importo' => 'required|integer|gt:0',
            'qta' => 'required|integer|gt:0'
          ];
          
          $data['nome'] = $servizio; 
          $data['contratto_id'] = $contratto_id; 
          
          if ($servizio == 'ALTRO') 
            {
            $validation_array['altro_servizio'] = 'required';
            
            $data['altro_servizio'] = $request->get('altro_servizio');
            } 
          else 
            {
            $validation_array['localita'] = 'required|not_in:SELEZIONA';

            $data['localita'] = $request->get('localita');
            }
    
          $request->validate($validation_array);
    
          $data['dal'] = $request->get('dal');
          $data['al'] = $request->get('al');
          $data['qta'] = $request->get('qta');
          $data['importo'] = $request->get('importo');


          ServizioDigitale::create($data);
          

          echo 'ok';

          }
        
        

        } // end SaveRigaServizioAjax
      
    

      public function exportPdf($id)
        {
        
        $contratto = ContrattoDigitale::withoutGlobalScope('data_creazione')->find($id);

        $pdf = $this->_crea_pdf($id);
        
        return $pdf->stream();

        return $pdf->download($contratto->nome_file.'.pdf');
        
        }
    

      
    
      

      public function creaPdfAjax(Request $request)
        {
          $contratto_id = $request->get('contratto_id');

          $pdf = $this->_crea_pdf($contratto_id);

          return 'ok';

        }


      

      private function _crea_pdf($id)
        {
        $n_servizi_per_pagina = 8;

        $contratto = ContrattoDigitale::withoutGlobalScope('data_creazione')->with(['commerciale','servizi','sconti_associati'])->find($id);

        $nome_file = $contratto->nome_file;

        $commerciale_contratto = optional($contratto->commerciale)->name;

        //================================================//
        // Servizi associati al contratto
        //================================================//

        //Tutti i sevizi NON SCONTO OPPURE gli sconti GENERICI
        $servizi_venduti = 
        $contratto->servizi()->where('sconto',0)
        ->orWhere(function($query) use ($id) {
          $query->where('contratto_id',$id);
          $query->where('sconto',1);
          $query->whereNull('servizio_scontato_id');
        })
        ->get();
  
        // tutti gli sconti associati ad un servizio
        $sconti = $contratto->sconti_associati->keyBy('servizio_scontato_id');


        $servizi_assoc = [];
        $totali = [];
        
        $this->getServiziAssociatiAndTotali($servizi_venduti, $sconti, $servizi_assoc, $totali);

        //================================================//
        // /Servizi associati al contratto 
        //================================================//
        
        
        $chunk_servizi = $servizi_assoc->chunk($n_servizi_per_pagina);

        
        $n_sottotab = $chunk_servizi->count();
        
        //return view('contratti_digitali.contratto_pdf', compact('contratto','commerciale_contratto','servizi_assoc','totali','n_servizi_per_pagina','chunk_servizi', 'n_sottotab'));

        $pdf = PDF::loadView('contratti_digitali.contratto_pdf', compact('contratto','commerciale_contratto','servizi_assoc','totali','n_servizi_per_pagina','chunk_servizi', 'n_sottotab'));


        
        $filepdf_path = storage_path('app/public/precontratti').'/'.$nome_file.'.pdf';
        $filepdf_firmato_path = storage_path('app/public/precontratti').'/'.$nome_file.'_firmato.pdf';

        $pdf->save($filepdf_path);

        $reader = new SetaPDF_Core_Reader_File($filepdf_path);
        $writer = new SetaPDF_Core_Writer_File($filepdf_firmato_path);
        $document = SetaPDF_Core_Document::load($reader, $writer);
    
    
        $pages = $document->getCatalog()->getPages();
        $pageCount = $pages->count();
        $penultima = $pageCount - 1;
       
        for ($i=1; $i <= $n_sottotab; $i++) 
          {

            // add a field left top with an offset of 10 points
            SignatureField::add(
                $document,
                'CLIENTE',
                $i,
                SignatureField::POSITION_RIGHT_BOTTOM,
                array('x' => -40, 'y' => 1),
                200,
                50
            );
          
          }


      
        ///////////////////////////////////////////
        // aggiungo le firme in penultima pagina //
        ///////////////////////////////////////////
        SignatureField::add(
            $document,
            'AgenteIA 1',
            $penultima,
            SignatureField::POSITION_LEFT_BOTTOM,
            array('x' => 70, 'y' => 260),
            200,
            50
        );

        SignatureField::add(
            $document,
            'CLIENTE 1',
            $penultima,
            SignatureField::POSITION_RIGHT_BOTTOM,
            array('x' => -70, 'y' => 260),
            200,
            50
        );    


        SignatureField::add(
            $document,
            'AgenteIA 2',
            $penultima,
            SignatureField::POSITION_LEFT_BOTTOM,
            array('x' => 70, 'y' => 70),
            200,
            50
        );

        SignatureField::add(
            $document,
            'CLIENTE 2',
            $penultima,
            SignatureField::POSITION_RIGHT_BOTTOM,
            array('x' => -70, 'y' => 70),
            200,
            50
        );
        


        ////////////////////////////////////////
        // aggiungo le firme in ultima pagina //
        ////////////////////////////////////////
        SignatureField::add(
            $document,
            'TITOLARE TRATTAMENTO',
            $pageCount,
            SignatureField::POSITION_RIGHT_BOTTOM,
            array('x' => -70, 'y' => 350),
            200,
            50
        );



        // save and finish
        $document->save()->finish();


        return $pdf;

        }
    
    
    
    
      
      
      
      
        /**
      * IBAN della società può essere già corretto oppure essere malformato
      *
      * @param [type] $iban
      * @return boolean
      */
      private function _guess_iban($iban)
      {
      $iban_check = explode(' ',$iban);

      if (count($iban_check) == 4) 
        {
        return true;
        } 
      else 
        {
        return false;
        }
      }

    
    private function getServiziAssociatiAndTotali($servizi_venduti, $sconti,&$servizi_assoc, &$totali)
      {
      $tot_importo = 0;
      $tot_qta = 0;
      $tot_iva = 0;
      $tot_importo_con_iva = 0;

      foreach ($servizi_venduti as $s) 
        {
        
        $s->sconto ? $tot_importo -= $s->importo : $tot_importo += $s->importo;

        $tot_qta += $s->qta;
        $servizi_assoc[] = $s;
        
        if ($s->scontato) 
          {
            $sconto = $sconti->get($s->id);
            $tot_importo -= $sconto->importo;
            $servizi_assoc[] = $sconto;
          }
        }

      $tot_iva = $tot_importo*Utility::getIva()/100;

      $tot_importo_con_iva = $tot_importo + $tot_iva;
        
      
      
      // ServiziDigitali associati al contratto
      // in cui ogni sconto è DOPO il servizio a cui è associato
      $servizi_assoc = collect($servizi_assoc);


      $totali['tot_importo'] = $tot_importo;
      $totali['tot_qta'] = $tot_qta;
      $totali['tot_iva'] = $tot_iva;
      $totali['tot_importo_con_iva'] = $tot_importo_con_iva;
      }

}
