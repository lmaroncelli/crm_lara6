<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\TipoEvidenza;
use App\MacroLocalita;
use Illuminate\Http\Request;

class EvidenzeController extends Controller
{
    public function index(Request $request, $macro_id = 0) 
      {
        
        $macro = MacroLocalita::orderBy('ordine')->pluck('nome','id');

        $tipi_evidenza = TipoEvidenza::with(['macroLocalita','mesi','evidenze','evidenze.mesi'])->ofMacro($macro_id)->get(); 

        // preparo un array tale che $cliente[id] = id_info senza dover fare sempre la query per ogni cella
        // dovrei filtrare per macrolocalita
        // scopeOfMacro($id_macro) x i clienti ??
        $clienti = Cliente::attivo()->pluck('id_info','id')->take(5);

        dd($clienti);

        return view('evidenze.griglia', compact('macro', 'macro_id','tipi_evidenza'));
      }
}
