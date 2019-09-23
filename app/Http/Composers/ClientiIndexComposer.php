<?php


namespace App\Http\Composers;


use Illuminate\Contracts\View\View;


/**
 * summary
 */
class ClientiIndexComposer
{		
    public function compose(View $view)
    	{

	    //////////////////////////////////////////////////////////
    	// campi esposti nella select di ricerca elenco clienti //
	    //////////////////////////////////////////////////////////
    	$campi_cliente_search = [];
    	$campi_cliente_search['cap'] = 'cap';
    	$campi_cliente_search['indirizzo'] = 'indirizzo';
    	$campi_cliente_search['telefono'] = 'telefono';
    	$campi_cliente_search['fax'] = 'fax';
    	$campi_cliente_search['cell'] = 'cell';
    	$campi_cliente_search['commerciale'] = 'commerciale';
    	$campi_cliente_search['email'] = 'email';
    	$campi_cliente_search['email_amministrativa'] = 'email_amministrativa';
    	$campi_cliente_search['pec'] = 'pec';
    	$campi_cliente_search['codice_destinatario'] = 'codice_destinatario';
    	$campi_cliente_search['note'] = 'note';
    	$campi_cliente_search['note_2'] = 'note_2';
    	$campi_cliente_search['web'] = 'web';
    	$campi_cliente_search['whatsapp'] = 'whatsapp';
    	$campi_cliente_search['sms'] = 'sms';
    	$campi_cliente_search['0'] = 'campo in cui cercare';

    	asort($campi_cliente_search);
    	$view->with(compact('campi_cliente_search'));

    	}
}