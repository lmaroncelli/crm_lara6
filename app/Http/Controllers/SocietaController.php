<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Societa;
use Illuminate\Http\Request;

class SocietaController extends Controller
{
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

      $societa = Societa::with(['ragioneSociale','cliente']); 



     //////////////////////////////////////
     // Ricerca campo libero del cliente //
     //////////////////////////////////////

      $join_rag_soc = 0;
      $join_clienti = 0;

      // se ho inserito un valore da cercare ed ho selzionato un campo
      if( !is_null($qf) && $field != '0' )
        {
        if (in_array($field, ['nome','localita','indirizzo','cap','piva','cf', 'pec', 'codice_sdi'])) 
          {

          if($field == 'localita')
            {
            $societa = $societa
                    ->select('tblSocieta.*')
                    ->join('tblRagioneSociale', 'tblSocieta.ragionesociale_id', '=', 'tblRagioneSociale.id')
                    ->join('tblLocalita', 'tblRagioneSociale.localita_id', '=', 'tblLocalita.id')
                    ->where('tblLocalita.nome','LIKE','%'.$qf.'%');
                
            }
          else
            {
            $societa = $societa
                      ->select('tblSocieta.*')
                      ->join('tblRagioneSociale', 'tblSocieta.ragionesociale_id', '=', 'tblRagioneSociale.id')
                      ->where('tblRagioneSociale.'.$field,'LIKE','%'.$qf.'%');
            }

          $join_rag_soc = 1;
          }
        elseif (in_array($field, ['note','banca','iban'])) 
          {
          $societa = $societa
                    ->select('tblSocieta.*')
                    ->where('tblSocieta.'.$field,'LIKE','%'.$qf.'%');
          }
        elseif ($field == 'cliente') 
          {
          $societa = $societa
                    ->select('tblSocieta.*')
                    ->join('tblClienti', 'tblSocieta.cliente_id', '=', 'tblClienti.id')
                    ->where('tblClienti.nome','LIKE','%'.$qf.'%');

          $join_clienti = 1;
          }
        }



      if(is_null($order))
        {
          $order='asc';
        }

      if(is_null($orderby))
        {
          $orderby='id';
        }
      
      $to_append = ['order' => $order, 'orderby' => $orderby, 'qf' => $qf, 'field' => $field];



      if ($orderby == 'nome_rag') 
        {
        if(!$join_rag_soc)
        {
        $societa = $societa
                ->select('tblSocieta.*')
                ->join('tblRagioneSociale', 'tblSocieta.ragionesociale_id', '=', 'tblRagioneSociale.id');
        }

        $societa = $societa
                ->orderBy('tblRagioneSociale.nome', $order);
        }

      if ($orderby == 'nome_cliente' || $orderby == 'id_info')
          {
          if(!$join_clienti)
            {
            $societa = $societa
                    ->join('tblClienti', 'tblSocieta.cliente_id', '=', 'tblClienti.id');
            } 

          if($orderby == 'nome_cliente') 
            {
            $societa = $societa
                    ->orderBy('tblClienti.nome', $order);
            }
          else
            {
            $societa = $societa
                    ->orderBy('tblClienti.id_info', $order);
            }
          }

      
      $societa = $societa
                  ->paginate(15)->setpath('')->appends($to_append);

      //dd($societa);
       
      return view('societa.index', compact('societa'));

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
    public function edit($id)
    {
        //
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
      $societa = Societa::find($id);
      $societa->destroyMe();

      return redirect()->route("societa.index")->with('status', 'Societa eliminata correttamente!');
    }




    public function fatture(Request $request, $cliente_id = 0, $societa_id = 0)
      {
        if (!$societa_id) 
          {
           return back()->with('status', 'Specificare la società!');
          }
        
        $orderby = $request->filled('orderby') ? $request->get('orderby') : 'id';
        $order = $request->filled('order') ? $request->get('order') : 'desc';
        

        $societa = Societa::with(['ragioneSociale.localita.comune.provincia','cliente'])->find($societa_id);

        
        $fatture = $societa->solo_fatture()->orderBy($orderby, $order)->get();

        $prefatture = $societa->prefatture()->orderBy($orderby, $order)->get();

        $ragioneSociale = $societa->ragioneSociale;
        
        $cliente = Cliente::find($cliente_id);

        $bread = [route('clienti.index') => 'Cienti', route('clienti-fatturazioni',$cliente->id) => $cliente->nome, 'Fatture'];

        return view('societa.fatture', compact('ragioneSociale', 'fatture', 'prefatture', 'cliente_id','societa_id','bread'));


      }


}
