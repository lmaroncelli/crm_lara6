<?php

namespace App\Http\Controllers;


use App\User;
use App\Cliente;
use App\ContrattoDigitale;
use App\Societa;
use App\Utility;
use App\RagioneSociale;
use Illuminate\Http\Request;
use App\Http\Controllers\MyController;

class ContrattiDigitaliController extends MyController
{

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
    public function index()
    {
        //
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
      if ($request->has('item') && $request->get('item') != '') 
        {
        $item = $request->get('item');
        list($id_info, $name) = explode("-", $item);

        $cliente = Cliente::with('localita')->byIdInfo($id_info)->first();
        $dati_cliente = $cliente->id_info . ' - ' .$cliente->nome."\n".$cliente->localita->nome;


        $rag_soc = RagioneSociale::with('localita.comune.provincia')->find($request->get('fatturazione'));

        $dati_fatturazione = $rag_soc->nome . "\n" .$rag_soc->indirizzo . "\n" . $rag_soc->cap . "-" .$rag_soc->localita->nome .'('. $rag_soc->localita->comune->provincia->sigla .") \nP.IVA: ". $rag_soc->piva . "\nCodice Fiscale: ".$rag_soc->cf;

        $societa = Societa::withRagioneSociale($rag_soc->id)->first();
        
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
        
        }
      

         $data = array (
         'user_id' => $request->id_commerciale,
         'cliente_id' => $cliente->id,
         'dati_cliente' => $dati_cliente,
         'data_creazione' => now(),
         'tipo_contratto' => $request->tipo_contratto,
         'segnalatore' => $request->segnalatore,
         'dati_fatturazione' => $dati_fatturazione,
         'dati_referente' => $request->referente,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $contratto = ContrattoDigitale::find($id);

      // gestione IBAN
      $this->_gestione_iban($i1, $i2, $i3, $i4, $mostra_iban_importato, $contratto);

      // elenco commerciali
      $utenti_commerciali = User::commerciale()->orderBy('name')->get();


      // servizi già associati a questo contratto
      $servizi_assoc = $this->_servizi_associati($contratto);

      //dd($contratto);

      $condizioni_pagamento = Utility::getCondizioniPagamento();

      return view('contratti_digitali.form', compact('contratto','i1','i2','i3','i4', 'mostra_iban_importato', 'utenti_commerciali','servizi_assoc','condizioni_pagamento'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
}
