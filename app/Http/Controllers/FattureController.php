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

class FattureController extends Controller
{


    private function _validate_riga_fatturazione(Request $request)
      {
        
        $validation_array = [
               'qta' => 'required|numeric',
               'prezzo' => 'required|numeric',
               'totale_netto' => 'required|numeric',
               'al_iva' => 'required|numeric',
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
      $iva = $totale_netto*$dati_riga['al_iva']/100;
      $totale = $totale_netto + $iva;
      
      $dati_riga['totale_netto'] = $totale_netto;
      $dati_riga['iva'] = $iva;
      $dati_riga['totale'] = $totale;

      }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
         $orderby='tblFatture.data';
       }
     

     $fattureEagerLoaded = Fattura::getFattureEagerLoaded($orderby);

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

      return view('fatture.index', compact('fatture'));
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


        return view('fatture.create', compact('fattura','tipo_pagamento'));
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

      $fattura = Fattura::create($request->except(['numero']));
      
      if ($request->get('tipo_id') == 'PF') 
        {
        $fattura->numero_prefattura = $request->get('numero');
        } 
      else 
        {
        $fattura->numero_fattura = $request->get('numero');
        }

      $fattura->save();
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

    if(!is_null($societa))
    {
    $prefatture_ids = $societa->prefatture->pluck('id')->toArray();
    
    $prefatture_da_associare = Fattura::with('pagamento')
                                ->whereHas(
                                    'scadenze' , function($q) {
                                      $q->where('pagata',0);
                                    }
                                )
                                ->whereIn('id', $prefatture_ids)
                                ->get();

      $prefatture_associate = $fattura->prefatture->pluck('id')->toArray();


    }

    
    return view('fatture.form', compact('fattura','riga_fattura', 'scadenza_fattura', 'servizio_prefill_arr','prefatture_da_associare','prefatture_associate'));
    
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
    public function fatturePrefattureAjax(Request $request)
      {
        $fattura_id = $request->get('fattura_id');
        $prefattura_id = $request->get('prefattura_id');
        $associa = $request->get('associa');
        
        $fattura = Fattura::find($fattura_id);

        $fattura->prefatture()->toggle([$prefattura_id]);

        if($associa == 'true')
          {
          $ris['type'] = 'success';
          $ris['title'] = 'Ok...';
          $ris['text'] = 'prefattura associata correttamente';
          }
        else
          {
          $ris['type'] = 'error';
          $ris['title'] = 'Ok...';
          $ris['text'] = 'prefattura disassociata correttamente';
          }
          echo json_encode($ris);
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


}
