<?php


namespace App\Http\Composers;


use App\CategoriaCliente;
use App\Contatto;
use App\Localita;
use App\TipologiaCliente;
use App\User;
use Illuminate\Contracts\View\View;


/**
 * summary
 */
class ClientiFormComposer
{
    public function compose(View $view)
    	{

    	$tipi_cliente = TipologiaCliente::pluck('nome','id')->toArray(); 
    	$cataegorie_cliente = CategoriaCliente::pluck('categoria','id')->toArray(); 
    	$localita_cliente = Localita::orderBy('nome','asc')->pluck('nome','id')->toArray(); 
    	$commerciali = User::commerciale()->orderBy('name')->pluck('name','id')->toArray();
    	$contatti = Contatto::orderBy('nome')->get();
    	$view->with(compact('tipi_cliente','cataegorie_cliente', 'localita_cliente','commerciali','contatti'));
    	}
}