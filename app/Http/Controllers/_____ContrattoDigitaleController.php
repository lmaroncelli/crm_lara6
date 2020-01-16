<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\MyController;

class ContrattoDigitaleController extends MyController
{
    public function new(Request $request, $id = 0) 
      {
        
      $clienti_autocomplete_js = Utility::getAutocompleteJs();

      return view('contratti_digitali.form', compact('clienti_autocomplete_js'));
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


    public function store(Request $request)
      {
        dd($request->all());
      }
    
}
