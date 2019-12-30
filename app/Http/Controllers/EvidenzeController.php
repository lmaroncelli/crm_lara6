<?php

namespace App\Http\Controllers;

use App\User;
use App\Cliente;
use App\TipoEvidenza;
use App\MacroLocalita;
use Illuminate\Http\Request;
use App\Http\Controllers\MyController;

class EvidenzeController extends MyController
{
    public function index(Request $request, $macro_id = 0) 
      {
        
        $macro = MacroLocalita::orderBy('ordine')->pluck('nome','id');

        $utenti_commerciali = User::commerciale()->get();


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

        return view('evidenze.griglia', compact('macro', 'macro_id','tipi_evidenza','clienti_to_info','commerciali','commerciali_nome'));
      }
}
