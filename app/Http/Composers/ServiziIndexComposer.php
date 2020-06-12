<?php


namespace App\Http\Composers;

use Illuminate\Contracts\View\View;


/**
 * summary
 */
class ServiziIndexComposer
{
    public function compose(View $view)
    	{
    	       //////////////////////////////////////////////////////////
                // campi esposti nella select di ricerca elenco clienti //
                //////////////////////////////////////////////////////////
                $campi_servizi_search = [];
                $campi_servizi_search['nome_prodotto'] = 'Prodotto';
                $campi_servizi_search['data_inizio'] = 'Inizio';
                $campi_servizi_search['data_fine'] = 'Scadenza';
                $campi_servizi_search['nome_cliente'] = 'Cliente';
                $campi_servizi_search['cliente_id'] = 'ID';
                $campi_servizi_search['note'] = 'Note';
                $campi_servizi_search['numero_fattura'] = 'N° Fattura';
                
                asort($campi_servizi_search);
                
                array_unshift($campi_servizi_search, 'campo in cui cercare');
                

                $view->with(compact('campi_servizi_search'));
    	}
}