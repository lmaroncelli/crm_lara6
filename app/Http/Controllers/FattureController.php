<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Fattura;
use App\Pagamento;
use App\RagioneSociale;
use App\RigaDiFatturazione;
use App\ScadenzaFattura;
use App\Servizio;
use App\Societa;
use App\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\MyTrait\MyTrait;

class FattureController extends Controller
{
    use MyTrait;

    private function _validate_riga_fatturazione(Request $request)
      {
        
        $validation_array = [
               'qta' => 'required|numeric',
               'prezzo' => 'required|numeric',
               'totale_netto' => 'required|numeric',
               'totale_netto_scontato' => 'required|numeric',
               'al_iva' => 'required|numeric',
               'perc_sconto' => 'required|numeric',
               'iva' => 'required|numeric',
               'totale' => 'required|numeric',
           ];

        if($request->has('servizio'))
          {
          $validation_array['servizio'] = 'required';
          }


        $validatedData = $request->validate($validation_array);
      }


    private function _validate_scadenza(Request $request)
      {
       $validation_array = [
              'data_scadenza' => 'required|date_format:"d/m/Y"|after:'.Carbon::today(),
              'importo' => 'required|numeric',
          ];

       $validatedData = $request->validate($validation_array); 
      }


    private function _ricalcola_dati_riga(&$dati_riga)
      {
      $totale_netto = $dati_riga['qta']*$dati_riga['prezzo'];
      $sconto = $totale_netto*$dati_riga['perc_sconto']/100;
      $totale_netto_scontato = $totale_netto - $sconto;
      $iva = $totale_netto_scontato*$dati_riga['al_iva']/100;
      $totale = $totale_netto_scontato + $iva;
      
      $dati_riga['totale_netto'] = $totale_netto;
      $dati_riga['iva'] = $iva;
      $dati_riga['totale'] = $totale;
      $dati_riga['totale_netto_scontato'] = $totale_netto_scontato;

      }


    
    public function prefatture(Request $request)
      {
      return $this->index($request, $tipo = 'PF');
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $tipo = 'F', $all = null)
    {

      // SOVRASCRIVO IL TIPO se MI VIENE PASSATO DALLA REQUEST
      if ($request->has('tipo') && $request->get('tipo') != $tipo) 
        {
        $tipo = $request->get('tipo');
        }


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
         $orderby='tblFatture.data';
       }
     
      if ( !is_null($all) && $all == 'all' )
        {
        $url_index = 'fatture/'.$tipo.'/all';
        $fattureEagerLoaded = Fattura::getFattureEagerLoaded($tipo,$orderby)->withoutGlobalScope('data');
        $all = 1;
        }
      else
        {
        $tipo == 'F' ? $url_index = 'fatture' : $url_index = 'prefatture';
        $fattureEagerLoaded = Fattura::getFattureEagerLoaded($tipo,$orderby);
        $all = 0;
        }

     $fatture = $fattureEagerLoaded;

     //////////////////////////////////////
     // Ricerca campo libero del cliente //
     //////////////////////////////////////

     // se ho inserito un valore da cercare ed ho selzionato un campo
     
     if( !is_null($qf) && $field != '0' )
       {
       if($field == 'data')
         {
         $request->validate([
             'qf' =>  'required|date_format:"d/m/Y"'
           ]);

         $fatture = $fatture->where('tblFatture.'.$field, '=', Utility::getCarbonDate($qf)->format('Y-m-d'));

         }
      elseif ($field == 'pagamento')
        {
        $pagamenti_ids = Pagamento::where('nome','LIKE','%'.$qf.'%')->pluck('cod')->toArray();
        $fatture = $fatture->whereIn('pagamento_id',$pagamenti_ids);        
        }
      elseif ($field == 'societa')
        {
        $ragSoc_ids = RagioneSociale::where('nome','LIKE','%'.$qf.'%')->pluck('id')->toArray();
        $cocieta_ids = Societa::whereIn('ragionesociale_id',$ragSoc_ids)->pluck('id')->toArray();
        $fatture = $fatture->whereIn('societa_id',$cocieta_ids);        

        }
      elseif ($field == 'piva')
        {
        $ragSoc_ids = RagioneSociale::where('piva','LIKE','%'.$qf.'%')->pluck('id')->toArray();
        $cocieta_ids = Societa::whereIn('ragionesociale_id',$ragSoc_ids)->pluck('id')->toArray();
        $fatture = $fatture->whereIn('societa_id',$cocieta_ids);        

        }
      elseif ($field == 'cliente')
        {
        $clienti_ids = Cliente::where('nome','LIKE','%'.$qf.'%')->pluck('id')->toArray();
        $cocieta_ids = Societa::whereIn('cliente_id',$clienti_ids)->pluck('id')->toArray();
        $fatture = $fatture->whereIn('societa_id',$cocieta_ids);
        }
      else
        {
         $fatture = $fatture->where('tblFatture.'.$field, 'LIKE', '%' . $qf . '%');
        }

       }


      
       if($orderby == 'tblFatture.data')
        {
        $orderby='data';
        }
       



      $to_append = ['order' => $order, 'orderby' => $orderby];
  
      if( !is_null($qf) && $field != '0' )
       {
       $to_append['qf'] = $qf;
       $to_append['field'] = $field;
       }



      $fatture = $fatture
                  ->orderBy($orderby, $order)
                  ->paginate(15)->setpath('')->appends($to_append);

      return view('fatture.index', compact('fatture','tipo','url_index','all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tipo_id = 'F')
    {
        $fattura = new Fattura;

        if ($tipo_id != 'NC') 
          {
          $tipo_pagamento = Pagamento::where('cod_PA','!=',NULL)->where('cod','!=',-1)->orderBy('nome','asc')->pluck('nome','cod');
          } 
        else 
          {
          $tipo_pagamento = Pagamento::where('cod','=',-1)->orderBy('nome','asc')->pluck('nome','cod');
          }

        
        $last_fatture = Fattura::getLastNumber($tipo_id);

        return view('fatture.create', compact('fattura','tipo_pagamento','tipo_id', 'last_fatture'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate([
             'societa' => 'required',
             'societa_id' => 'required|integer',
             'numero' => 'required',
             'data' => 'required|date_format:"d/m/Y"'
         ]);

      $fattura = Fattura::create($request->all());
      
      return redirect('fatture/'.$fattura->id.'/edit');
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
    public function edit($id, $rigafattura_id = 0, $scadenza_fattura_id = 0)
    {
    $fattura = Fattura::with([
                          'pagamento',
                          'righe',
                          'scadenze',
                          'societa.RagioneSociale.localita.comune.provincia',
                          'societa.cliente.servizi_non_fatturati',
                          'prefatture',
                        ])->find($id);

    if($rigafattura_id)
      {
      $riga_fattura = RigaDiFatturazione::find($rigafattura_id);
      }
    else
      {
      $riga_fattura = null;
      }


    if($scadenza_fattura_id)
      {
      $scadenza_fattura = ScadenzaFattura::find($scadenza_fattura_id);
      }
    else
      {
      $scadenza_fattura = null;
      }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // SE NON SONO UNA 'NC'
    // con l'id della societa voglio trovare tutti i servizi NON FATTURATI associati al cliente di questa societa //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    ///////////////////////////////////////////////////////////////////////////////////////
    // riesco a caricarle come rigediFatturazione prendendo il prezzo dai precontratti?? //
    ///////////////////////////////////////////////////////////////////////////////////////

    $servizio_prefill_arr = [];


    if(is_null($riga_fattura))
      {
      if($fattura->societa->cliente->servizi_non_fatturati->count())
        {
        foreach ($fattura->societa->cliente->servizi_non_fatturati as $servizio) 
          {
          $servizio_prefill_arr[$servizio->id] =  $servizio->getValueforRigaFatturazione();
          }
        }
      }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // SE NON SONO UNA 'NC'
    // con l'id della societa voglio trovare tutte le scadenze non pagate risalenti a prefatture di questa società //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $societa = $fattura->societa;

    $prefatture_da_associare = null;
    $prefatture_associate = [];

    if(!is_null($societa) && $fattura->tipo_id != 'PF')
    {
    $prefatture_ids = $societa->prefatture->pluck('id')->toArray();
    
    // $prefatture_da_associare = Fattura::with('pagamento')
    //                             ->whereHas(
    //                                 'scadenze' , function($q) {
    //                                   $q->where('pagata',0);
    //                                 }
    //                             )
    //                             ->whereIn('id', $prefatture_ids)
    //                             ->get();


    // considero tra le prefatture da associare anche quelle già pagate PERO' le evidenzio e non le faccio selezionare
    $prefatture_da_associare = $societa->prefatture;

    $prefatture_associate = $fattura->prefatture->pluck('id')->toArray();
      
    }

    if ($fattura->tipo_id != 'NC') 
      {
      $tipo_pagamento = Pagamento::where('cod_PA','!=',NULL)->where('cod','!=',-1)->orderBy('nome','asc')->pluck('nome','cod');
      } 
    else 
      {
      $tipo_pagamento = Pagamento::where('cod','=',-1)->orderBy('nome','asc')->pluck('nome','cod');
      }
    
    return view('fatture.form', compact('fattura','riga_fattura', 'scadenza_fattura', 'servizio_prefill_arr','prefatture_da_associare','prefatture_associate','tipo_pagamento'));
    
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
      Fattura::destroy($id);
      return redirect()->route('fatture.index')->with('status', 'Fattura elimnata correttamente!');
    }



    // visualizza le ultime fatture di un tipo
    public function lastFattureAjax(Request $request)
      {
        $tipo_id = $request->get('tipo_id');
        $last_fatture = Fattura::getLastNumber($tipo_id);

        echo view('fatture._numeri_fatture', compact('last_fatture'));
      }


      // aggiunge la riga alla fattura
      public function addRiga(Request $request)
        {
         //dd($request->get('servizi'));
        $this->_validate_riga_fatturazione($request);

        $fattura_id = $request->get('fattura_id');

        $dati_riga = $request->except('servizi');
        
        $this->_ricalcola_dati_riga($dati_riga);

        $riga_fattura = RigaDiFatturazione::create($dati_riga);

        Fattura::find($fattura_id)->righe()->save($riga_fattura);

        ///////////////////////////////////////////////////////
        // assegno ai servizi selezionati l'id della fattura //
        ///////////////////////////////////////////////////////

        // in realtà è sempre hidden perché onSubmit del form chiamo la funzione servizi_select_to_servizio_text()
        // hidden

        $servizi = $request->get('servizi');

        if(!is_array($servizi))
          {
          $servizi = explode(',', $servizi);
          }

        if(count($servizi))
          {
          Servizio::whereIn('id',$servizi)->update(['rigafatturazione_id' => $riga_fattura->id, 'fattura_id' => $fattura_id]);
          }

        return redirect('fatture/'.$fattura_id.'/edit');

        }


    // carica riga di fatturazione x modifica 
    public function loadRiga(Request $request, $rigafattura_id)
      {

      $riga_fattura = RigaDiFatturazione::find($rigafattura_id);

      $fattura_id = $riga_fattura->fattura_id;

      return redirect('fatture/'.$fattura_id.'/edit/'.$rigafattura_id);

      }


    // update riga di fatturazione
    public function updateRiga(Request $request, $rigafattura_id)
      {

      $this->_validate_riga_fatturazione($request);
      
      $riga_fattura = RigaDiFatturazione::find($rigafattura_id);
      $fattura_id = $riga_fattura->fattura_id;
     
      $dati_riga = $request->all();
      $this->_ricalcola_dati_riga($dati_riga);

      $riga_fattura->update($dati_riga);

      return redirect('fatture/'.$fattura_id.'/edit');

      }


    public function deleteRiga(Request $request)
      {
      $rigafattura_id = $request->get('rigafattura_id');
      $riga_fattura = RigaDiFatturazione::find($rigafattura_id);
      $fattura_id = $riga_fattura->fattura_id;
      $riga_fattura->delete();

      if (!$riga_fattura->fattura->righe()->count()) 
        {
        $f = $riga_fattura->fattura;
        $f->azzeraTotale();
        $f->save();
        }
      
       return redirect('fatture/'.$fattura_id.'/edit');
      }


    public function addNote(Request $request)
      {
      $fattura_id = $request->get('fattura_id');

      $fattura = Fattura::find($fattura_id);
      $fattura->note = $request->get('note');

      $fattura->save();

      return redirect('fatture/'.$fattura_id.'/edit');
      }


    // chiamata AJAX in seguito ad un click sul checkbox della prefattura da associare o disassociare
    // public function fatturePrefattureAjax(Request $request)
    //   {
    //     $fattura_id = $request->get('fattura_id');
    //     $prefattura_id = $request->get('prefattura_id');
    //     $associa = $request->get('associa');
        
    //     $fattura = Fattura::find($fattura_id);

    //     $fattura->prefatture()->toggle([$prefattura_id]);

    //     if($associa == 'true')
    //       {
    //       $ris['type'] = 'success';
    //       $ris['title'] = 'Ok...';
    //       $ris['text'] = 'prefattura associata correttamente';
    //       }
    //     else
    //       {
    //       $ris['type'] = 'error';
    //       $ris['title'] = 'Ok...';
    //       $ris['text'] = 'prefattura disassociata correttamente';
    //       }
    //       echo json_encode($ris);
    //   }


    public function associaFatturaPrefatturaAjax(Request $request)
      {
        $prefattura_id = $request->get('prefattura_id');
        $fattura_id = $request->get('fattura_id');
        $associa = $request->get('associa');

        $fattura = Fattura::find($fattura_id);

        if (!is_null($fattura)) 
          {
          if ($associa=='true') 
            {
            $fattura->prefatture()->attach($prefattura_id);
            echo "attaccato $prefattura_id";
            } 
          else 
            {
            $fattura->prefatture()->detach($prefattura_id);
            echo "stattaccato $prefattura_id";
            }

          echo "ok";
          } 
        else 
          {
          echo "ko";
          }

      }

    
    public function cambiaIntestazioneFatturaAjax(Request $request)
      {
      $fattura_id = $request->get('fattura_id');
      $societa_id = $request->get('societa_id');

      $fattura = Fattura::find($fattura_id);

      if (!is_null($fattura)) 
        {
        $fattura->societa_id = $societa_id;
        $fattura->save();

        echo $fattura->societa->nome;
        } 
      else 
        {
        echo "ko";
        }
      
      }


    public function cambiaPagamentoFatturaAjax(Request $request)
      {
      $fattura_id = $request->get('fattura_id');
      $pagamento_id = $request->get('pagamento_id');

      $fattura = Fattura::find($fattura_id);

      if (!is_null($fattura)) 
        {
        $fattura->pagamento_id = $pagamento_id;
        $fattura->save();

        echo "ok";
        } 
      else 
        {
        echo "ko";
        }
      }

    public function addScadenza(Request $request)
      {
      $this->_validate_scadenza($request);

      $fattura_id = $request->get('fattura_id');

      $dati_scadenza = $request->all();

      $scadenza_fattura = ScadenzaFattura::create($dati_scadenza);

      Fattura::find($fattura_id)->righe()->save($scadenza_fattura);
      
      return redirect('fatture/'.$fattura_id.'/edit');

      }


    public function updateScadenza(Request $request, $scadenza_fattura_id = 0)
      {
      $this->_validate_scadenza($request);

      $scadenza_fattura = ScadenzaFattura::find($scadenza_fattura_id);

      $fattura_id = $scadenza_fattura->fattura_id;

      $scadenza_fattura->update($request->all());

      return redirect('fatture/'.$fattura_id.'/edit');

      }

    public function loadScadenza(Request $request, $scadenza_fattura_id = 0)
      {
      $scadenza_fattura = ScadenzaFattura::find($scadenza_fattura_id);

      $fattura_id = $scadenza_fattura->fattura_id;

      return redirect('fatture/'.$fattura_id.'/edit/0/'.$scadenza_fattura_id);
      }


    public function deleteScadenza(Request $request)
      {
      $scadenza_fattura_id = $request->get('scadenza_fattura_id');
      
      $scadenza_fattura = ScadenzaFattura::find($scadenza_fattura_id);
      
      $fattura_id = $scadenza_fattura->fattura_id;
      
      $scadenza_fattura->delete();

       return redirect('fatture/'.$fattura_id.'/edit');
      }


     public function pdf(Request $request, $fattura_id)
      {

      return $this->getPdfFattura($request, $fattura_id);
      
      }


      public function getXmlPA($fattura_id)
        {
        $fattura = Fattura::with(
            [
              'righe',
              'scadenze',
              'servizi',
              'pagamento',
              'societa.ragioneSociale.localita.comune.provincia',
              'societa.cliente',
            ]
          )
          ->find($fattura_id);
          



          // CREATE XRM AS STRING

          $xmlString = '';

          $formatoTrasmissione = null;
          $codiceDestinatario = null;
          $PECDestinatario = null;

          $tipoDocumento = null;
          $cf = null;
          $sigla_provincia = '';





          $trova_iva_22 = false;
          $trova_iva_null_N1 = false;
          $trova_iva_null_N1_bis = false;
          $trova_iva_null_N2 = false;
          $trova_iva_null_N2_bis = false;
          $trova_iva_null_N3 = false;
          $imponibileImporto = 0;
          $imponibileImporto_iva_nulla_N1 = 0;
          $imponibileImporto_iva_nulla_N2 = 0;
          $imponibileImporto_iva_nulla_N3 = 0;
          $imponibileImporto_iva_nulla_N2_bis = 0;
          $imponibileImporto_iva_nulla_N1_bis = 0;



          $codice_sdi_fattura = $fattura->societa->ragioneSociale->codice_sdi;

          $sigla_provincia = $fattura->societa->ragioneSociale->localita->comune->provincia->sigla;

          // Attualmente la fattura verso il pubblico viene fatta solo a Gupi (Polizia Regionale) //
          $codice_sdi_fattura == 'UFFHH9' ? $formatoTrasmissione = 'FPA12' : $formatoTrasmissione = 'FPR12';
          

          $codice_sdi_fattura == '' ? $codiceDestinatario = '0000000' : $codiceDestinatario  = $codice_sdi_fattura;
          

          // Indirizzo PEC al quale inviare il documento. Da valorizzare SOLO nei casi in cui l'elemento informativo 1.1.4 <CodiceDestinatario> vale '0000000'
          $codiceDestinatario == '0000000' ? $PECDestinatario = $fattura->societa->ragioneSociale->pec : $PECDestinatario = '';

          
          if($fattura->pagamento->cod_PA == '')
            {
            $fattura->cod_PA = 'MP01';
            }
        
          $fattura->numero_fattura = str_replace("/","", $fattura->numero_fattura);

          if($fattura->tipo_fattura == 'F')
            {
            $tipoDocumento = 'TD01';
            }
          
          if($fattura->tipo_fattura == 'NC')
            {
            $tipoDocumento = 'TD04';
            }
          
          $fattura->societa->ragioneSociale->cf == '' ? $cf = $fattura->societa->ragioneSociale->piva : $cf = $fattura->societa->ragioneSociale->cf;


          $xmlString .= 
          '<p:FatturaElettronica xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:p="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" versione="FPR12" xsi:schemaLocation="http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2 http://www.fatturapa.gov.it/export/fatturazione/sdi/fatturapa/v1.2/Schema_del_file_xml_FatturaPA_versione_1.2.xsd">
            <FatturaElettronicaHeader>
                <DatiTrasmissione>
                    <IdTrasmittente>
                        <IdPaese>IT</IdPaese>
                        <IdCodice>03479440400</IdCodice>
                    </IdTrasmittente>
                    <ProgressivoInvio>'.$fattura->numero_fattura.'</ProgressivoInvio>
                    <FormatoTrasmissione>'.$formatoTrasmissione.'</FormatoTrasmissione>
                    <CodiceDestinatario>'.$codiceDestinatario.'</CodiceDestinatario>';

          if($PECDestinatario != '')
            {
            $xmlString .=
            '<PECDestinatario>'.$PECDestinatario.'</PECDestinatario>';
            }
          
          $xmlString .= 
            '</DatiTrasmissione>
            <CedentePrestatore>
                <DatiAnagrafici>
                    <IdFiscaleIVA>
                    <IdPaese>IT</IdPaese>
                    <IdCodice>03479440400</IdCodice>
                    </IdFiscaleIVA>
                    <Anagrafica>
                    <Denominazione>Info Alberghi S.r.l.</Denominazione>
                    </Anagrafica>
                    <RegimeFiscale>RF01</RegimeFiscale>
                </DatiAnagrafici>
                <Sede>
                    <Indirizzo>Via Gambalunga, 81/A</Indirizzo>
                    <CAP>47921</CAP>
                    <Comune>Rimini</Comune>
                    <Provincia>RN</Provincia>
                    <Nazione>IT</Nazione>
                </Sede>
            </CedentePrestatore>';




            if ($sigla_provincia == 'SM') 
              {
              $idpaese = 'SM';
              $codice_fiscale = 'hidden';
              } 
            else 
              {
              $idpaese = 'IT';
              $codice_fiscale = '';
              }

            $xmlString .= 
              '<CessionarioCommittente>
                  <DatiAnagrafici>
                      <IdFiscaleIVA>
                          <IdPaese>'.$idpaese.'</IdPaese>
                          <IdCodice>'.$fattura->societa->ragioneSociale->piva.'</IdCodice>
                      </IdFiscaleIVA>';

            if($codice_fiscale != 'hidden')
              {
              $xmlString .= '<CodiceFiscale>'.$cf.'</CodiceFiscale>';
              }
            
            $xmlString .= 
                    '<Anagrafica>
                        <Denominazione>'.Utility::onlyAlpha(htmlspecialchars($fattura->societa->ragioneSociale->nome)).'</Denominazione>
                    </Anagrafica>
                </DatiAnagrafici>
                <Sede>
                    <Indirizzo>'.$fattura->societa->ragioneSociale->indirizzo.'</Indirizzo>
                    <CAP>'.$fattura->societa->ragioneSociale->cap.'</CAP>
                    <Comune>'.$fattura->societa->ragioneSociale->localita->comune->nome.'</Comune>
                    <Provincia>'.$sigla_provincia.'</Provincia>
                    <Nazione>'.$idpaese.'</Nazione>
                </Sede>
              </CessionarioCommittente>
            </FatturaElettronicaHeader>';

            
            $xmlString .= 
            '<FatturaElettronicaBody>
              <DatiGenerali>
                <DatiGeneraliDocumento>
                <TipoDocumento>'.$tipoDocumento.'</TipoDocumento>
                <Divisa>EUR</Divisa>
                <Data>'.$fattura->data.'</Data>
                <Numero>'.$fattura->numero_fattura.'</Numero>
                <ImportoTotaleDocumento>'.sprintf('%.2f',$fattura->totale).'</ImportoTotaleDocumento>
                <Causale>'.Utility::onlyAlpha(substr(htmlspecialchars(str_replace(["€","/"], ["euro","-"],$fattura->note)), 0, 180)).'</Causale>';

                if (strlen(Utility::onlyAlpha(substr(htmlspecialchars(str_replace(["€","/"], ["euro","-"],$fattura->note)), 180)))) 
                  {
                  $xmlString .= '<Causale>'.Utility::onlyAlpha(substr(htmlspecialchars(str_replace(["€","/"], ["euro","-"],$fattura->note)), 180)).'</Causale>';
                  }
              
            $xmlString .= 
                  '</DatiGeneraliDocumento>
              </DatiGenerali>';

            $xmlString .= 
              '<DatiBeniServizi>';

            
            foreach ($fattura->righe as $key => $riga_fatturazione) 
              {
                $nl = $key+1;

                $xmlString .= '<DettaglioLinee>';
                $xmlString .= '<NumeroLinea>'. $nl.'</NumeroLinea>';
                $xmlString .= 
                '<Descrizione>'. Utility::onlyAlpha(htmlspecialchars(str_replace(["€","/"], ["euro","-"],$riga_fatturazione->servizio))) .'</Descrizione>
                <Quantita>'. sprintf('%.2f',$riga_fatturazione->qta) .'</Quantita>
                <PrezzoUnitario>'. sprintf('%.2f',$riga_fatturazione->prezzo) .'</PrezzoUnitario>';

                if (!$riga_fatturazione->perc_sconto) 
                  {
                  $xmlString .= '<PrezzoTotale>'. sprintf('%.2f',$riga_fatturazione->totale_netto) .'</PrezzoTotale>';  
                  }
                else
                  {
                  $importo_sconto = $riga_fatturazione->totale_netto - $riga_fatturazione->totale_netto_scontato;
                  $xmlString .= '<ScontoMaggiorazione><Tipo>SC</Tipo>';
                  $xmlString .= '<Percentuale>'.$riga_fatturazione->perc_sconto.'</Percentuale>';
                  $xmlString .= '<Importo>'.sprintf('%.2f',$importo_sconto).'</Importo>';
                  $xmlString .= '</ScontoMaggiorazione>';  
                  $xmlString .= '<PrezzoTotale>'. sprintf('%.2f',$riga_fatturazione->totale_netto_scontato) .'</PrezzoTotale>';  
                  }

                $xmlString .= '<AliquotaIVA>'. sprintf('%.2f',$riga_fatturazione->al_iva) .'</AliquotaIVA>';

                

                if ($riga_fatturazione->al_iva == 0 && (strpos($riga_fatturazione->servizio, 'art.15 DPR 633/72') !== false || strpos($riga_fatturazione->servizio, 'art. 15 DPR 633/72') !== false)) 
                  {
                  $xmlString .= '<Natura>N1</Natura>';

                  if (!$riga_fatturazione->perc_sconto) 
                    {
                    $imponibileImporto_iva_nulla_N1 += $riga_fatturazione->totale_netto;
                    }
                  else
                    {
                    $imponibileImporto_iva_nulla_N1 += $riga_fatturazione->totale_netto_scontato;
                    }
                  
                  if(!$trova_iva_null_N1)
                    {
                    $trova_iva_null_N1 = true;
                    }
                  }               
                elseif($riga_fatturazione->al_iva == 0 && ( strpos($riga_fatturazione->servizio, 'art.2 DPR 633/72') !== false || strpos($riga_fatturazione->servizio, 'art. 2 DPR 633/72') !== false)) 
                  {
                  
                  $xmlString .= '<Natura>N2</Natura>';

                  if (!$riga_fatturazione->perc_sconto) 
                    {
                    $imponibileImporto_iva_nulla_N2 += $riga_fatturazione->totale_netto;
                    }
                  else
                    {
                    $imponibileImporto_iva_nulla_N2 += $riga_fatturazione->totale_netto_scontato;
                    
                    }

                  if(!$trova_iva_null_N2)
                    {
                    $trova_iva_null_N2 = true;
                    }

                  } 
                elseif($riga_fatturazione->al_iva == 0 && ( strpos($riga_fatturazione->servizio, 'ex Art. 7 comma 4 DPR 633/72') !== false || strpos($riga_fatturazione->servizio, 'ex Art.7 comma 4 DPR 633/72') !== false ||  strpos($fattura->note, 'ex Art.7 comma 4 DPR 633/72') !== false ||  strpos($fattura->note, 'ex Art. 7 comma 4 DPR 633/72') !== false))
                  {
                  
                  $xmlString .= '<Natura>N3</Natura>';

                  if (!$riga_fatturazione->perc_sconto) 
                    {
                    $imponibileImporto_iva_nulla_N3 += $riga_fatturazione->totale_netto;
                    }
                  else
                    {
                    $imponibileImporto_iva_nulla_N3 += $riga_fatturazione->totale_netto_scontato;                 
                    }

                  if(!$trova_iva_null_N3)
                    {
                    $trova_iva_null_N3 = true;
                    }
                  
                  }
                elseif($riga_fatturazione->al_iva == 0 && (strpos($riga_fatturazione->servizio, 'FUORI CAMPO IVA ART.13') !== false))
                  {
                    $xmlString .= '<Natura>N2</Natura>';

                    if (!$riga_fatturazione->perc_sconto) 
                      {
                      $imponibileImporto_iva_nulla_N2_bis += $riga_fatturazione->totale_netto;
                      }
                    else
                      {
                      $imponibileImporto_iva_nulla_N2_bis += $riga_fatturazione->totale_netto_scontato;
                      
                      }
    
                    if(!$trova_iva_null_N2_bis)
                      {
                      $trova_iva_null_N2_bis = true;
                      }
                  }
                elseif($riga_fatturazione->al_iva == 0 && (strpos($riga_fatturazione->servizio, 'Escl.art.15') !== false) )
                  {

                    $xmlString .= '<Natura>N1</Natura>';

                    if (!$riga_fatturazione->perc_sconto) 
                      {
                      $imponibileImporto_iva_nulla_N1_bis += $riga_fatturazione->totale_netto;
                      }
                    else
                      {
                      $imponibileImporto_iva_nulla_N1_bis += $riga_fatturazione->totale_netto_scontato;
                      }
                    
                    if(!$trova_iva_null_N1_bis)
                      {
                      $trova_iva_null_N1_bis = true;
                      }

                  }
                else 
                  {
                  
                  if (!$riga_fatturazione->perc_sconto) 
                  {
                  $imponibileImporto += $riga_fatturazione->totale_netto;
                  }
                else
                  {
                  $imponibileImporto += $riga_fatturazione->totale_netto_scontato;
                  }
                  
                if (!$trova_iva_22) 
                  {
                  $trova_iva_22 = true;
                  $iva = $riga_fatturazione->al_iva;
                  }

                  }
                
                $xmlString .= '</DettaglioLinee>';

              } // endforeach
            
            if($trova_iva_22)
              {
              $imposta = $imponibileImporto*$iva/100;
              $xmlString .= '
              <DatiRiepilogo>
                <AliquotaIVA>'. sprintf('%.2f',$iva) .'</AliquotaIVA>
                <ImponibileImporto>'. sprintf('%.2f',$imponibileImporto) .'</ImponibileImporto>
                <Imposta>'. sprintf('%.2f',$imposta) .'</Imposta>
                <EsigibilitaIVA>I</EsigibilitaIVA>
              </DatiRiepilogo>';
              }
            
            if($trova_iva_null_N1)
              {
              $xmlString .= '
              <DatiRiepilogo>
                <AliquotaIVA>0.00</AliquotaIVA>
                <Natura>N1</Natura>
                <ImponibileImporto>'. sprintf('%.2f',$imponibileImporto_iva_nulla_N1) .'</ImponibileImporto>
                <Imposta>0.00</Imposta>
                <RiferimentoNormativo>Art.15 DPR 633/72</RiferimentoNormativo>
              </DatiRiepilogo>';
              }
            
            if($trova_iva_null_N1_bis)
              {
              $xmlString .= '
              <DatiRiepilogo>
                <AliquotaIVA>0.00</AliquotaIVA>
                <Natura>N1</Natura>
                <ImponibileImporto>'. sprintf('%.2f',$imponibileImporto_iva_nulla_N1_bis) .'</ImponibileImporto>
                <Imposta>0.00</Imposta>
                <RiferimentoNormativo>Escl.art.15</RiferimentoNormativo>
              </DatiRiepilogo>';
              }
            
            if($trova_iva_null_N2)
              {
              $xmlString .= '
              <DatiRiepilogo>
                <AliquotaIVA>0.00</AliquotaIVA>
                <Natura>N2</Natura>
                <ImponibileImporto>'. sprintf('%.2f',$imponibileImporto_iva_nulla_N2) .'</ImponibileImporto>
                <Imposta>0.00</Imposta>
                <RiferimentoNormativo>Fuori campo iva ex art. 2 DPR 633/72</RiferimentoNormativo>
              </DatiRiepilogo>';
              }
            
            if($trova_iva_null_N2_bis)
              {
              $xmlString .= '
              <DatiRiepilogo>
                <AliquotaIVA>0.00</AliquotaIVA>
                <Natura>N2</Natura>
                <ImponibileImporto>'. sprintf('%.2f',$imponibileImporto_iva_nulla_N2_bis) .'</ImponibileImporto>
                <Imposta>0.00</Imposta>
                <RiferimentoNormativo>FUORI CAMPO IVA ART.13</RiferimentoNormativo>
              </DatiRiepilogo>';
              }

            if($trova_iva_null_N3)
              {
              $xmlString .= '
              <DatiRiepilogo>
                <AliquotaIVA>0.00</AliquotaIVA>
                <Natura>N3</Natura>
                <ImponibileImporto>'. sprintf('%.2f',$imponibileImporto_iva_nulla_N3) .'</ImponibileImporto>
                <Imposta>0.00</Imposta>
                <RiferimentoNormativo>Fattura esente ex Art. 7 comma 4 DPR 633/72</RiferimentoNormativo>
              </DatiRiepilogo>';
              }
            
            $xmlString .= '</DatiBeniServizi>';
            
             /*
            Pagamento: molte righe scadenza == ripetere <DettaglioPagamento> ??
            TP01 pagamento a rate
            TP02 pagamento completo
            */
            
            if ($fattura->righe()->count()) 
              {
              $condizioniPagamento = 'TP01';
              } 
            else 
              {
              $condizioniPagamento = 'TP02';
              }
            
            $xmlString .= '
            <DatiPagamento>
              <CondizioniPagamento>'.$condizioniPagamento.'</CondizioniPagamento>';

            // se è NC

            if ($tipoDocumento == 'TD04') 
              {
                $totale = $imponibileImporto + $imposta + $imponibileImporto_iva_nulla_N1;
                $xmlString .= '
                  <DettaglioPagamento>
                    <ModalitaPagamento>'.$fattura->pagamento->cod_PA.'</ModalitaPagamento>
                    <DataScadenzaPagamento>'.$fattura->data.'</DataScadenzaPagamento>
                    <ImportoPagamento>'.sprintf('%.2f',$totale).'</ImportoPagamento>
                  </DettaglioPagamento>';
              } 
            else 
              {
                foreach ($fattura->scadenze as $riga_scadenza) 
                  {
                    $xmlString .= '
                    <DettaglioPagamento>
                      <ModalitaPagamento>'.$fattura->pagamento->cod_PA.'</ModalitaPagamento>
                      <DataScadenzaPagamento>'.$riga_scadenza->data_scadenza.'</DataScadenzaPagamento>
                      <ImportoPagamento>'.sprintf('%.2f',$riga_scadenza->importo).'</ImportoPagamento>
                      <IstitutoFinanziario>'.Utility::getBancaIa()['nome'].'</IstitutoFinanziario>
                      <IBAN>'.Utility::getBancaIa()['iban'].'</IBAN>
                      <ABI>'.Utility::getBancaIa()['abi'].'</ABI>
                      <CAB>'.Utility::getBancaIa()['cab'].'</CAB>
                    </DettaglioPagamento>';
                  }
              }

            $xmlString .= 
                  '</DatiPagamento>
                </FatturaElettronicaBody>
          </p:FatturaElettronica>';




          $replace = array("");

          $find = array("&","'"," ");
          $nome_hotel = str_replace($find,$replace,strtolower($fattura->societa->cliente->nome));
          
          $find = array("/","\\");
          $numero_fattura = str_replace($find,$replace,$fattura->numero_fattura);

          $nomefile = $numero_fattura.'_'.$nome_hotel.'.xml';

          header('Content-type: text/xml; charset=utf-8');
          header('Content-Disposition: attachment; filename="'.$nomefile.'"');


          echo $xmlString;


        } // end function getXmlPA



}
