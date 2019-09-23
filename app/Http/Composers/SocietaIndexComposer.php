<?php


namespace App\Http\Composers;

use Illuminate\Contracts\View\View;


/**
 * summary
 */
class SocietaIndexComposer
{
    public function compose(View $view)
    	{
    	       //////////////////////////////////////////////////////////
                // campi esposti nella select di ricerca elenco clienti //
                //////////////////////////////////////////////////////////
                $campi_societa_search = [];
                $campi_societa_search['nome'] = 'societa';
                $campi_societa_search['localita'] = 'località';
                $campi_societa_search['pec'] = 'pec';
                $campi_societa_search['codice_sdi'] = 'codice sdi';
                $campi_societa_search['indirizzo'] = 'indirizzo';
                $campi_societa_search['cap'] = 'cap';
                $campi_societa_search['piva'] = 'P. IVA';
                $campi_societa_search['cf'] = 'codice fiscale';
                
                $campi_societa_search['note'] = 'note';
                $campi_societa_search['banca'] = 'banca';
                $campi_societa_search['iban'] = 'iban';

                $campi_societa_search['cliente'] = 'cliente';
                asort($campi_societa_search);
                
                array_unshift($campi_societa_search, 'campo in cui cercare');
                
                

                $view->with(compact('campi_societa_search'));
    	}
}