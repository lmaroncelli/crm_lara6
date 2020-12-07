<?php

use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** 

| GET|HEAD | login                      | login            | App\Http\Controllers\Auth\LoginController@showLoginForm                | web,guest                                       |
| POST     | login                      |                  | App\Http\Controllers\Auth\LoginController@login                        | web,guest                                       |
| POST     | logout                     | logout           | App\Http\Controllers\Auth\LoginController@logout                       | web                                             |
| POST     | password/email             | password.email   | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web,guest                                       |
 GET|HEAD | password/reset             | password.request | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web,guest                                       |
| POST     | password/reset             | password.update  | App\Http\Controllers\Auth\ResetPasswordController@reset                | web,guest                                       |
| GET|HEAD | password/reset/{token}     | password.reset   | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web,guest                                       |
| GET|HEAD | register                   | register         | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web,guest                                       |
| POST     | register                   |                  | App\Http\Controllers\Auth\RegisterController@register                  | web,guest                                       |
*/


Route::get('/', '\App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');

Auth::routes(['except' => 'login']);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::middleware(['auth'])->group(function () {

	/**    
    |        | POST      | clienti                | clienti.store    | App\Http\Controllers\ClientiController@store                           | web,auth     |
    |        | GET|HEAD  | clienti                | clienti.index    | App\Http\Controllers\ClientiController@index                           | web,auth     |
    |        | GET|HEAD  | clienti/create         | clienti.create   | App\Http\Controllers\ClientiController@create                          | web,auth     |
    |        | PUT|PATCH | clienti/{clienti}      | clienti.update   | App\Http\Controllers\ClientiController@update                          | web,auth     |
    |        | GET|HEAD  | clienti/{clienti}      | clienti.show     | App\Http\Controllers\ClientiController@show                            | web,auth     |
    |        | DELETE    | clienti/{clienti}      | clienti.destroy  | App\Http\Controllers\ClientiController@destroy                         | web,auth     |
    |        | GET|HEAD  | clienti/{clienti}/edit | clienti.edit     | App\Http\Controllers\ClientiController@edit                            | web,auth     |
	*/
    /////////////
    // CLIENTI //
    /////////////
    Route::model('clienti', 'App\Cliente');
    Route::resource('clienti', 'ClientiController')/*->middleware('log')*/;


    Route::get('clienti/fatturazioni/{cliente_id}', 'ClientiFatturazioniController@index')->name('clienti-fatturazioni');
    Route::get('clienti/fatturazioni-edit/{societa_id}', 'ClientiFatturazioniController@edit')->name('clienti-fatturazioni.edit');
    Route::post('clienti/fatturazioni-update/{societa_id}', 'ClientiFatturazioniController@update')->name('clienti-fatturazioni.update');
    Route::post('clienti/fatturazioni-destroy/{societa_id}', 'ClientiFatturazioniController@destroy')->name('clienti-fatturazioni.destroy');

    Route::get('clienti/servizi/{cliente_id}/{venduti?}', 'ClientiServiziController@index')->name('clienti-servizi');
    Route::get('clienti/servizi/archiviati/{cliente_id}', 'ClientiServiziController@archiviati')->name('clienti-servizi-archiviati');
    
    Route::post('clienti/servizi-destroy/{servizio_id}', 'ClientiServiziController@destroy')->name('clienti-servizi.destroy');
    Route::post('clienti/servizi/archivia', 'ClientiServiziController@archiviaAjax')->name('clienti-servizi-archivia');


    Route::get('clienti/contratti/{cliente_id}', 'ClientiController@elencoContratti')->name('clienti-contratti');
    Route::post('clienti/contratto-destroy/{contratto_id}', 'ClientiController@destroyContratto')->name('clienti-contratto-destroy');
    // https://www.positronx.io/laravel-file-upload-with-validation/
    Route::post('clienti/contratto-upload', 'ClientiController@uploadContratto')->name('contratto-upload');
    

    Route::get('clienti/foto/{cliente_id}', 'ClientiController@elencoFoto')->name('clienti-foto');
    Route::post('clienti/foto-save', 'ClientiController@saveFoto')->name('clienti-foto-save');
    Route::post('clienti/foto-destroy/{foto_id}', 'ClientiController@destroyFoto')->name('clienti-foto-destroy');



    Route::get('/associa-societa-ajax', 'ClientiFatturazioniController@associaSocietaAjax');



    //////////////
    // CONTATTI //
    //////////////
    Route::model('contatti', 'App\Contatto');
    Route::resource('contatti', 'ContattiController')/*->middleware('log')*/;
    Route::post('/gestisci-contatti-ajax', 'ClientiController@gestisciContattiAjax');


    //////////////
    // SCOCIETA //
    //////////////
    Route::model('societa', 'App\Societa');
    Route::resource('societa', 'SocietaController')/*->middleware('log')*/;

    Route::get('societa/fatture/{cliente_id}/{societa_id}', 'SocietaController@fatture')->name('societa-fatture');


    /////////////
    // FATTURE //
    /////////////

    
    
    // sovrascrivo create
    Route::get('fatture/create/{tipo_id?}', 'FattureController@create')->name('fatture.create');
    // sovrascrivo edit
    Route::get('fatture/{fattura_id}/edit/{rigafattura_id?}/{scadenza_fattura_id?}', 'FattureController@edit')->name('fatture.edit');



    Route::get('fatture/xml/{fattura_id}', 'FattureController@getXmlPA')->name('fatture.xml-pa');
    

    Route::resource('fatture', 'FattureController')/*->middleware('log')*/;
    
    
    
    Route::post('fatture/add-scadenza', 'FattureController@addScadenza')->name('fatture.add-scadenza');
    Route::post('fatture/update-scadenza/{scadenza_fattura_id}', 'FattureController@updateScadenza')->name('fatture.update-scadenza');
    Route::get('fatture/load-scadenza/{scadenza_fattura_id}', 'FattureController@loadScadenza')->name('fatture.load-scadenza');
    Route::post('fatture/delete-scadenza', 'FattureController@deleteScadenza')->name('fatture.delete-scadenza');
    


    Route::post('fatture/add-riga', 'FattureController@addRiga')->name('fatture.add-riga');
    Route::post('fatture/add-note', 'FattureController@addNote')->name('fatture.add-note');
    Route::get('fatture/load-riga/{rigafattura_id}', 'FattureController@loadRiga')->name('fatture.load-riga');
    Route::post('fatture/update-riga/{rigafattura_id}', 'FattureController@updateRiga')->name('fatture.update-riga');
    Route::post('fatture/delete-riga', 'FattureController@deleteRiga')->name('fatture.delete-riga');    
    Route::post('/fatture-prefatture-ajax', 'FattureController@fatturePrefattureAjax');

    Route::get('fatture/pdf/{fattura_id}/{salva?}', 'FattureController@pdf')->name('fatture.pdf');
    
    // ATTENZIONE questa route deve andare in fondo a tutte quelle di tipo fatture/*
    Route::get('fatture/{tipo?}/{all?}', 'FattureController@index');

    // index prefatture
    Route::get('prefatture', 'FattureController@prefatture')->name('prefatture.index');
    


    Route::post('/last-fatture-ajax', 'FattureController@lastFattureAjax');
    
    Route::post('/associa-fattura-prefattura-ajax', 'FattureController@associaFatturaPrefatturaAjax');
    
    Route::post('/cambia-intestazione-fattura-ajax', 'FattureController@cambiaIntestazioneFatturaAjax');


    Route::post('/cambia-pagamento-fattura-ajax', 'FattureController@cambiaPagamentoFatturaAjax');







    ///////////////
    // EVIDENZE //
    //////////////

    Route::get('evidenze/{macro_id?}', 'EvidenzeController@index')->name('evidenze.view');

    
    Route::post('evidenze/crea_griglia_evidenza_ajax', 'EvidenzeController@creaGrigliaEvidenzaAjax')->name('crea_griglia_evidenza_ajax');



    Route::get('seleziona-cliente-evidenze-ajax', 'EvidenzeController@SelezionaClienteEvidenzeAjax')->name('seleziona-cliente-evidenze-ajax');

    Route::get('assegna-mese-evidenza-ajax', 'EvidenzeController@AssegnaMeseEvidenzaAjax')->name('assegna-mese-evidenza-ajax');

    Route::get('cambia-cliente', 'EvidenzeController@CambiaCliente')->name('cambia-clinte');

    Route::get('acquista-evidenza-ajax', 'EvidenzeController@AcquistaEvidenzaAjax')->name('acquista-evidenza-ajax');
    Route::get('annulla_acquisto_evidenza_ajax', 'EvidenzeController@AnnullaAcquistoEvidenzaAjax')->name('annulla_acquisto_evidenza_ajax');

    Route::get('prelaziona-evidenza-ajax', 'EvidenzeController@PrelazionaEvidenzaAjax')->name('prelaziona-evidenza-ajax');
    Route::get('disassocia-mese-evidenza-prelazione-ajax', 'EvidenzeController@DisassociaMeseEvidenzaPrelazioneAjax')->name('disassocia-mese-evidenza-prelazione-ajax');

    Route::get('assegna-costo-tipo-evidenza-mese-ajax', 'EvidenzeController@AssegnaCostoTipoEvidenzaMeseAjax')->name('assegna-costo-tipo-evidenza-mese-ajax');

    
    

     ////////////////////////
    // CONTRATTI DIGITALI //
    ////////////////////////

    Route::get('contratto-digitale/{all?}', 'ContrattiDigitaliController@index');
    Route::resource('contratto-digitale', 'ContrattiDigitaliController');

    // sovrascrivo edit
    Route::get('contratto-digitale/{contratto_id}/edit/{macro_id?}', 'ContrattiDigitaliController@edit')->name('contratto-digitale.edit');
    

    Route::get('load-fatturazione-contratto-digitale-ajax', 'ContrattiDigitaliController@LoadFatturazioneContrattoDigitaleAjax')->name('load-fatturazione-contratto-digitale-ajax');

    Route::get('load-referente-contratto-digitale-ajax', 'ContrattiDigitaliController@LoadReferenteContrattoDigitaleAjax')->name('load-referente-contratto-digitale-ajax');

    Route::post('del-riga-servizio-ajax', 'ContrattiDigitaliController@DelRigaServizioAjax')->name('del-riga-servizio-ajax');
    Route::post('load-riga-sconto-ajax', 'ContrattiDigitaliController@LoadRigaScontoAjax')->name('load-riga-sconto-ajax');
    Route::post('save-riga-sconto-ajax', 'ContrattiDigitaliController@SaveRigaScontoAjax')->name('save-riga-sconto-ajax');
    Route::post('load-riga-servizio-ajax', 'ContrattiDigitaliController@LoadRigaServizioAjax')->name('load-riga-servizio-ajax');

    
    Route::post('save-riga-servizio-ajax', 'ContrattiDigitaliController@SaveRigaServizioAjax')->name('save-riga-servizio-ajax');


    Route::get('contratto-digitale/export_pdf/{contratto_id}', 'ContrattiDigitaliController@exportPdf')->name('contratto-digitale.export-pdf');

    Route::post('contratto-digitale/crea_pdf_ajax', 'ContrattiDigitaliController@creaPdfAjax')->name('contratto-digitale.crea-pdf-ajax');

    Route::post('contratto-digitale/crea_griglia_evidenza_contratto_ajax', 'ContrattiDigitaliController@creaGrigliaEvidenzaContrattoAjax')->name('crea_griglia_evidenza_contratto_ajax');

    Route::post('contratto-digitale/carica_servizi_contratto_ajax', 'ContrattiDigitaliController@caricaServiziContrattoAjax')->name('carica_servizi_contratto_ajax');
    


    /////////////
    // Servizi //
    /////////////
    
    Route::get('servizi/{tipo?}', 'ServiziController@index')->name('servizi.index');
    
    Route::delete('/servizi/{id}', 'ServiziController@destroy')->name('servizi.destroy');



    //////////////
    // Scadenze //
    //////////////
    Route::post('servizi/send_mail_avviso_pagamento_ajax','ScadenzeController@sendMailAvvisoPagamentoAjax')->name('send-mail-avviso-pagamento-ajax');    
    Route::get('scadenze', 'ScadenzeController@index')->name('scadenze.index');

    Route::get('scadenze_csv', 'ScadenzeController@export_csv')->name('scadenze.csv');




    /////////////
    // MEMOREX //
    /////////////

    Route::resource('memorex', 'MemorexController')/*->middleware('log')*/;


    //////////////
    // CONTEGGI // 
    //////////////
    Route::get('conteggi/index_commerciali', 'ConteggiController@indexCommerciali')->name('conteggi.index_commerciali');
    
    Route::get('conteggi/{commerciale_id?}', 'ConteggiController@index')->name('conteggi.index');


    
    
    Route::post('conteggi', 'ConteggiController@store')->name('conteggi.store');

    Route::get('conteggi/{id}/edit','ConteggiController@edit')->name('conteggi.edit');

    Route::delete('/conteggio-riga/{riga_conteggio_id}', 'ConteggiController@destroyRiga')->name('conteggi.destroy.riga');

    Route::get('conteggi/{id}/termina','ConteggiController@termina')->name('conteggi.termina');
    Route::get('conteggi/{id}/apri','ConteggiController@apri')->name('conteggi.apri');
    Route::get('conteggi/{id}/approva','ConteggiController@approva')->name('conteggi.approva');



     /////////////
    // LOCALITA //
    /////////////
    Route::get('localita/comune/create', 'LocalitaController@comune_create')->name('comune.create');
    Route::post('localita/comune/store', 'LocalitaController@comune_store')->name('comune.store');
    Route::post('localita/comune/update/{comune_id}', 'LocalitaController@comune_update')->name('comune.update');

    Route::resource('localita', 'LocalitaController');


    /////////////
    // VETRINE //
    /////////////


    Route::resource('vetrine', 'VetrineController');
    Route::get('vetrina/slots/{vetrina_id}', 'VetrineController@slot_index')->name('slot.index');
    Route::get('vetrina/slot/create/{vetrina_id}', 'VetrineController@slot_create')->name('slot.create');
    Route::post('vetrina/slot/store/{vetrina_id}', 'VetrineController@slot_store')->name('slot.store');
    Route::post('vetrina/slot/update/{slot_id}', 'VetrineController@slot_update')->name('slot.update');
    Route::get('vetrina/slot/edit/{slot_id}', 'VetrineController@slot_edit')->name('slot.edit');
    Route::post('vetrina/slot/destroy/{slot_id}', 'VetrineController@slot_destroy')->name('slot.destroy');




        
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/prova', 'HomeController@prova');


