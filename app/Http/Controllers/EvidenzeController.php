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

class EvidenzeController extends MyController
{
    public function index(Request $request, $macro_id = 0) 
      {
        
        $macro = MacroLocalita::orderBy('ordine')->pluck('nome','id');

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
}
