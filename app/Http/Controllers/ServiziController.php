<?php

namespace App\Http\Controllers;

use App\Prodotto;
use App\Servizio;
use App\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiziController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $tipo=null)
      {


      //dd($request->all());

      /**
       * array:4 [▼
          "orderby" => null
          "order" => null
          "qf" => "sabri"
          "field" => "nome_cliente"
          ]
      */

      // campo libero
      $qf = $request->get('qf');
      $field = $request->get('field');


      // prodotti
      $prodotti = $request->get('prodotti');
      $inizio = $request->get('inizio');
      $scadenza = $request->get('scadenza');

      $archiviato = $request->get('archiviato');


      $orderby = $request->get('orderby');
      $order = $request->get('order');

      $servizi = Servizio::
      						whereHas(
      							'cliente' , function($q) {
                     $q->where('attivo',1);
                   	})
      						->with(['cliente.localita','prodotto','fattura']);


      if(!is_null($tipo))
        {
        $servizi = $servizi->evidenze();
        }


      if(is_null($archiviato))
        {
        $servizi = $servizi->notArchiviato();
        }
      						

      $join_clienti = 0;
      $join_prodotti = 0;



      //////////////////////
      // Ricerca Prodotti //
      //////////////////////

       
      if(!is_null($prodotti))
        {
        $servizi = $servizi
                    ->select('tblServizi.*')
                    ->whereIn('tblServizi.prodotto_id', $prodotti);
        }

      if(!is_null($inizio))
        {
        $inizio_input = Carbon::createFromFormat('d/m/Y', $inizio)->toDateString();
        $servizi = $servizi->where('data_inizio','>=',$inizio_input);
        }

      if(!is_null($scadenza))
        {
        $scadenza_input = Carbon::createFromFormat('d/m/Y', $scadenza)->toDateString();
        $servizi = $servizi->where('data_fine','<=',$scadenza_input);
        }


      // se ho inserito un valore da cercare ed ho selzionato un campo
      if( !is_null($qf) && $field != '0' )
        {

        if($field == 'nome_cliente')
          {
            $servizi = $servizi
                ->select('tblServizi.*')
                ->join('tblClienti', 'tblServizi.cliente_id', '=', 'tblClienti.id')
                ->where('tblClienti.nome','LIKE','%'.$qf.'%');

            $join_clienti = 1;
          }

        if($field == 'cliente_id')
          {
            $servizi = $servizi
                ->select('tblServizi.*')
                ->join('tblClienti', 'tblServizi.cliente_id', '=', 'tblClienti.id')
                ->where('tblClienti.id_info', $qf);

            $join_clienti = 1;
          }

        if($field == 'data_inizio' || $field == 'data_fine')
          {
          // la data passata deve essere nel formato gg/mm/yyyy       
          $field_input = Carbon::createFromFormat('d/m/Y', $qf)->toDateString();

          $servizi = $servizi
                    ->select('tblServizi.*')
                    ->where('tblServizi.'.$field, $field_input);

          }

        if($field == 'note')
          {
          $servizi = $servizi
                    ->select('tblServizi.*')
                    ->where('tblServizi.'.$field,'LIKE','%'.$qf.'%');
          }


        if($field == 'numero_fattura')
          {
          $servizi = $servizi
              ->select('tblServizi.*')
              ->join('tblFatture', 'tblServizi.fattura_id', '=', 'tblFatture.id')
              ->where('tblFatture.numero_fattura','LIKE','%'.$qf.'%');
          }


        if($field == 'nome_prodotto')
          {
          $servizi = $servizi
                ->select('tblServizi.*')
                ->join('tblProdotti', 'tblServizi.prodotto_id', '=', 'tblProdotti.id')
                ->where('tblProdotti.nome','LIKE','%'.$qf.'%');

          $join_prodotti = 1;

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
      
      $to_append = [
              'order' => $order, 
              'orderby' => $orderby, 
              'archiviato' => $archiviato,
              'qf' => $qf, 
              'field' => $field, 
              'prodotti' => $prodotti, 
              'tipo' => $tipo,
              'inizio' => $inizio,
              'scadenza' =>  $scadenza];

      if($orderby == 'data_inizio' || $orderby == 'data_fine')
        {
        $servizi = $servizi
                    ->orderBy($orderby, $order);
        }      

      if ($orderby == 'nome_cliente' || $orderby == 'id_info' || $orderby == 'localita_id') 
        {

        if(!$join_clienti)
          {
        	$servizi = $servizi
                ->select('tblServizi.*')
                ->join('tblClienti', 'tblServizi.cliente_id', '=', 'tblClienti.id');
          }

        if ($orderby == 'nome_cliente') 
          {
          $servizi = $servizi
                  ->orderBy('tblClienti.nome', $order);
          } 
        else 
          {
          $servizi = $servizi
                  ->orderBy('tblClienti.'.$orderby, $order);
          } 

        }

      if ($orderby == 'nome_prodotto') 
        {
          if(!$join_prodotti)
            {
            $servizi = $servizi
                  ->select('tblServizi.*')
                  ->join('tblProdotti', 'tblServizi.prodotto_id', '=', 'tblProdotti.id');
            }

          $servizi = $servizi
                    ->orderBy('tblProdotti.nome', $order);
        }


       $servizi = $servizi
                  ->paginate(15)->setpath('')->appends($to_append);



      if (is_null($tipo)) 
        {
        $prodotti = Prodotto::pluck('nome','id');
        } 
      else 
        {
        $prodotti = Prodotto::where('id',Utility::getIdProdottoEvidenza())->get()->pluck('nome','id');
        }

      return view('servizi.index', compact('servizi','tipo', 'prodotti'));
      }
}
