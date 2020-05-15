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
                $campi_servizi_search['nome'] = 'societa';
                $campi_servizi_search['localita'] = 'località';
                $campi_servizi_search['pec'] = 'pec';
                $campi_servizi_search['codice_sdi'] = 'codice sdi';
                $campi_servizi_search['indirizzo'] = 'indirizzo';
                $campi_servizi_search['cap'] = 'cap';
                $campi_servizi_search['piva'] = 'P. IVA';
                $campi_servizi_search['cf'] = 'codice fiscale';
                
                $campi_servizi_search['note'] = 'note';
                $campi_servizi_search['banca'] = 'banca';
                $campi_servizi_search['iban'] = 'iban';

                $campi_servizi_search['cliente'] = 'cliente';
                asort($campi_servizi_search);
                
                array_unshift($campi_servizi_search, 'campo in cui cercare');
                
                

                $view->with(compact('campi_servizi_search'));
    	}
}