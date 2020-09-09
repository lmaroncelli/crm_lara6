<?php

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
    //Route::model('fatture', 'App\Fattura');
    Route::resource('fatture', 'FattureController')/*->middleware('log')*/;
    
    // sovrascrivo create
    Route::get('fatture/create/{tipo_id?}', 'FattureController@create')->name('fatture.create');
    
    // sovrascrivo edit
    Route::get('fatture/{fattura_id}/edit/{rigafattura_id?}/{scadenza_fattura_id?}', 'FattureController@edit')->name('fatture.edit');

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

    Route::post('/last-fatture-ajax', 'FattureController@lastFattureAjax');

    Route::post('/associa-fattura-prefattura-ajax', 'FattureController@associaFatturaPrefatturaAjax');
    
    Route::post('/cambia-intestazione-fattura-ajax', 'FattureController@cambiaIntestazioneFatturaAjax');


    Route::post('/cambia-pagamento-fattura-ajax', 'FattureController@cambiaPagamentoFatturaAjax');




    ///////////////
    // EVIDENZE //
    //////////////

    Route::get('evidenze/{macro_id?}', 'EvidenzeController@index')->name('evidenze.view');

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


    /////////////
    // Servizi //
    /////////////
    Route::get('servizi/{tipo?}', 'ServiziController@index')->name('servizi.index');
    
    Route::delete('/servizi/{id}', 'ServiziController@destroy')->name('servizi.destroy');



    //////////////
    // Scadenze //
    //////////////
    Route::get('scadenze', 'ScadenzeController@index')->name('scadenze.index');




    /////////////
    // MEMOREX //
    /////////////

    Route::resource('memorex', 'MemorexController')/*->middleware('log')*/;


        
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
