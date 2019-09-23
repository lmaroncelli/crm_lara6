<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Contatto;
use App\User;
use Illuminate\Http\Request;

class ClientiController extends Controller
{

    /**
     * Display a listing of the resource.
     * Capacità di cercare e ordinare
     *
     * @return \Illuminate\Http\Response
     */  
    public function index(Request $request)
      {

       //dd($request->all());

        $q = $request->get('q');
        $qc = $request->get('qc');


        // campo libero
        $qf = $request->get('qf');
        $field = $request->get('field');



        $orderby = $request->get('orderby');
        $order = $request->get('order');


        ////////////////////////////////////
        // RIcerca per campo del contatto //
        ////////////////////////////////////
        $clienti_ids = [];

        if(!is_null($qc))
          {
          
          // cerco gli ids dei contatti che soddisfano
          $contatti = Contatto::where('nome','LIKE','%'.$qc.'%')->orWhere('email','LIKE','%'.$qc.'%')->orWhere('cellulare','LIKE','%'.$qc.'%')->orWhere('note','LIKE','%'.$qc.'%')->get();

          // se non trovo contatti non trovo neanche clienti
          if($contatti->count())
            {
            foreach ($contatti as $contatto) 
              {
              foreach ($contatto->clientiIds() as $cliente_id) 
                {
                $clienti_ids[] = $cliente_id;
                }
              }
            }
          else
            {
            $clienti_ids[] = -1;
            }

          
          $clienti_ids = array_unique($clienti_ids);
          
          }
        ///////////////////////////////////////
        // \ RIcerca per campo del contatto //
        ///////////////////////////////////////

        if(is_null($order))
          {
            $order='asc';
          }

        if(is_null($orderby))
          {
            $orderby='tblClienti.id_info';
          }
        elseif ($orderby == 'localita') 
          {
          $orderby = 'nome_localita';
          }

        $attivo_ia = $request->get('attivo_ia');
        $attivo = $request->get('attivo');


        $clienteEagerLoaded = Cliente::getClienteEagerLoaded($orderby);


        $clienti = $clienteEagerLoaded;

        if($attivo_ia == 'on')
          {
          $clienti = $clienti->where('attivo_ia',1);
          }

        if($attivo == 'on')
          {
          $clienti = $clienti->where('attivo',1);
          }


        //////////////////////////////////////
        // Ricerca campo libero del cliente //
        //////////////////////////////////////

        // se ho inserito un valore da cercare ed ho selzionato un campo
        
        if( !is_null($qf) && $field != '0' )
          {
          if($field == 'commerciale')
            {
            $commerciali = User::commerciale()->where('name','LIKE','%'.$qf.'%')->get();
            if($commerciali->count())
              {
              foreach ($commerciali as $commerciale) 
                {
                foreach ($commerciale->clientiAssociatiIds() as $cliente_id) 
                {
                $clienti_ids[] = $cliente_id;
                }
                }
                
                $clienti_ids = array_unique($clienti_ids);
              }
            }
          else
            {
            $clienti = $clienti->where('tblClienti.'.$field, 'LIKE', '%' . $qf . '%');
            }

          }


        if(count($clienti_ids))
          {
          $clienti = $clienti->whereIn('tblClienti.id', $clienti_ids);
          }

        $clienti = $clienti->where(function ($query) use ($q) {
                        $query->where('tblClienti.nome','LIKE','%'.$q.'%')
                              ->orWhere('tblClienti.id_info','LIKE','%'.$q.'%');
                        })
                  ->orderBy($orderby, $order);
        

        if($orderby == 'tblClienti.id_info')
          {
            $orderby='id_info';
          }
        elseif ($orderby == 'nome_localita') 
          {
          $orderby = 'localita';
          }
        
        
        $to_append = ['q' => $q, 'order' => $order, 'orderby' => $orderby];
       

        if($attivo_ia == 'on')
          {
          $to_append['attivo_ia'] = "on";
          }

       if($attivo == 'on')
        {
        $to_append['attivo'] = "on";
        }

        if(!is_null($qc))
          {
          $to_append['qc'] = $qc;
          }

         if( !is_null($qf) && $field != '0' )
          {
          $to_append['qf'] = $qf;
          $to_append['field'] = $field;
          }


        //dd($clienti->toSql());

        $clienti = $clienti->paginate(15)->setpath('')->appends($to_append);

        
        
        if($clienti->count())
          {
          return view('clienti.index', compact('clienti'));
          }
        else
          {
          return view('clienti.index')->withMessage('Nessun risultato trovato!');
          }

      }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Cliente $cliente)
    {
     return view('clienti.form', compact('cliente'));   
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



    /**
     * [gestisciContattiAjax chiamata ajax quando faccio check su un contatto dal form del cliente]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function gestisciContattiAjax(Request $request)
      {
        $contatto_id = $request->get('contatto_id');
        $cliente_id = $request->get('cliente_id');
        
        $cliente = Cliente::find($cliente_id); 

        $cliente->contatti()->toggle([$contatto_id]);

        echo 'ok';

      }
    
}
