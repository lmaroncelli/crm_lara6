<?php

namespace App\Http\Controllers;

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

    
    public function SelezionaClienteContrattoDigitaleAjax(Request $request) {
    
    }
}
