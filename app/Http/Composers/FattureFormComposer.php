<?php


namespace App\Http\Composers;

use App\Fattura;
use App\RagioneSociale;
use Illuminate\Contracts\View\View;


/**
 * summary
 */
class FattureFormComposer
{
    public function compose(View $view)
    	{
    	$ragioneSociale = RagioneSociale::getListForSelectModal();
        
    	$tipo_fattura = ['F' => 'Fattura', 'PF' => 'Prefattura', 'NC' => 'Nota di credito'];

    	$last_fatture = Fattura::getLastNumber();

    	$view->with(compact('ragioneSociale', 'tipo_fattura', 'last_fatture'));
    	}
}