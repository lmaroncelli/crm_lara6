<?php

use App\Cliente;
use App\User;
use App\Memorex;
use Carbon\Carbon;
use App\CommercialeMemorex;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\MemorexCollection;
use App\Http\Resources\Memorex as MemorexResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



// CONTEGGI //

Route::get('/conteggi/clientiCommerciale/{commerciale_id}', function($commerciale_id){
  $clienti = [];

  $clienti_associati = User::with([
    'clienti_associati.servizi_attivi.righeConteggi',
    'clienti_associati.localita'])
                ->find($commerciale_id)
                ->clienti_associati;



  // voglio prendere solo i clienti che hanno dei servizi da conteggiare
//   $clienti_filtered = $clienti_associati->reject(function ($cliente, $key) {

//     $all_servizi = $cliente->servizi_attivi;
//     $all_servizi->loadCount('righeConteggi');
//     $trovato = false;
//     foreach ($all_servizi as $servizio) {
//       if( $servizio->righeConteggi_count == 0) {
//       // CE NE E' ALMENO 1 CHE NON E' IN NESSUN CONTEGGIO 
//       $trovato = true;
//       break;
//       }
//     }

//     // il cliente lo prendo (NON LO RIGETTO)
//     return !$trovato;
  
// });

$clienti_filtered = $clienti_associati;

foreach ($clienti_filtered as $cliente) {
  $clienti[$cliente->id] = $cliente->nome . ' (' . $cliente->id_info . ') - '. $cliente->localita->nome;
}

return $clienti;

});


// servizi del cliente non in tblRigaConteggioServizio
Route::get('/conteggi/serviziCliente/{cliente_id}', function($cliente_id){
  $servizi = [];
  
  $cliente = Cliente::find($cliente_id);

  $all_servizi = $cliente->servizi_attivi;

  // $servizi_filtered = $all_servizi->reject(function ($servizio, $key) {
  //   return $servizio->righeConteggi()->count() > 0;
  // });

  $servizi_filtered = $all_servizi;

  foreach ($servizi_filtered as $servizio) 
    {
    $servizi[$servizio->id] = optional($servizio->prodotto)->nome . ' scade il ' . optional($servizio->data_fine)->format('d/m/Y');
    }

  return $servizi;	
});




// FINE CONTEGGI //
















//MEMOREX//


Route::get('/memorex/riferimenti', function(){
	$riferimenti = CommercialeMemorex::pluck('nome','id')
                    ->toArray();
	
    return $riferimenti;	
});


Route::get('/memorex/scadute/{order_by?}/{order?}', function($order_by='id',$order='desc') {
    
    
    if ($order_by == 'riferimento') 
      {

      $memorex = Memorex::select('tblScadenzeMemorex.*')
                          ->scadute()
                          ->notHM()
                          ->with('commerciale')
                          ->leftJoin('tblCommercialiMemorex', 'tblCommercialiMemorex.id', '=', 'tblScadenzeMemorex.commerciale_id')
                          ->orderBy('tblCommercialiMemorex.nome',$order)
                          ->paginate(15);
      } 
    else 
      {
        $memorex = Memorex::notHM()
        ->scadute()
        ->orderBy($order_by,$order)
        ->paginate(15);
      }

    return new MemorexCollection($memorex); 
});


Route::get('/memorex/non-scadute/{order_by?}/{order?}', function($order_by='id',$order='desc') {

    if ($order_by == 'riferimento') 
      {

      $memorex = Memorex::select('tblScadenzeMemorex.*')
                        ->nonScadute()
                        ->notHM()
                        ->with('commerciale')
                        ->leftJoin('tblCommercialiMemorex', 'tblCommercialiMemorex.id', '=', 'tblScadenzeMemorex.commerciale_id')
                        ->orderBy('tblCommercialiMemorex.nome',$order)
                        ->paginate(15);
      } 
    else 
      {
        $memorex = Memorex::notHM()
                    ->nonScadute()
                    ->orderBy($order_by,$order)
                    ->paginate(15);
      }

    return new MemorexCollection($memorex); 
});

Route::get('/memorex/archivio/{order_by?}/{order?}', function($order_by='id',$order='desc') {

  if ($order_by == 'riferimento') 
    {

    $memorex = Memorex::select('tblScadenzeMemorex.*')
                      ->where('completato', 1)
                      ->notHM()
                      ->with('commerciale')
                      ->leftJoin('tblCommercialiMemorex', 'tblCommercialiMemorex.id', '=', 'tblScadenzeMemorex.commerciale_id')
                      ->orderBy('tblCommercialiMemorex.nome',$order)
                      ->paginate(15);
    } 
  else 
    {
    $memorex = Memorex::notHM()
                ->where('completato', 1)
                ->orderBy($order_by,$order)
                ->paginate(15);
    }

    return new MemorexCollection($memorex); 
});



Route::get('memorex/{id}', function ($id) {
    $memorex = Memorex::find($id);

    return new MemorexResource($memorex);	

});


Route::patch('memorex/{id}', function(Request $request, $id) {
    $data_arr = $request->get('data');

    Memorex::findOrFail($id)
    			->update([
    				'titolo' => $data_arr['titolo'],
    				'descrizione' => str_replace("\n", "<br/>", $data_arr['descrizione']),
    				'data' => Carbon::createFromFormat('d/m/Y', $data_arr['data'])->format('Y-m-d'),
    				'categoria' => $data_arr['categoria'],
    				'priorita' => $data_arr['priorita'],
    				'commerciale_id' => $data_arr['commerciale_id']
    			]);
});



Route::post('memorex/store', function(Request $request) {
  $data_arr = $request->get('data');

  return Memorex::create([
            'titolo' => $data_arr['titolo'],
            'descrizione' => str_replace("\n", "<br/>", $data_arr['descrizione']),
            'data' => Carbon::createFromFormat('d/m/Y', $data_arr['data'])->format('Y-m-d'),
            'categoria' => $data_arr['categoria'],
            'priorita' => $data_arr['priorita'],
            'commerciale_id' => $data_arr['commerciale_id']
        ]);
});





Route::get('memorex/search/{search}/{order_by?}/{order?}', function ($search,$order_by='id',$order='desc') {

  if ($order_by == 'riferimento') 
    {
    $memorex = Memorex::select('tblScadenzeMemorex.*')
                    ->notHM()
                    ->where('titolo','LIKE', '%'.$search.'%')
                    ->with('commerciale')
                    ->leftJoin('tblCommercialiMemorex', 'tblCommercialiMemorex.id', '=', 'tblScadenzeMemorex.commerciale_id')
                    ->orderBy('tblCommercialiMemorex.nome',$order)
                    ->paginate(15);
    } 
  else 
    {
    $memorex = Memorex::notHM()
                ->where('titolo','LIKE', '%'.$search.'%')
                ->orderBy($order_by,$order)
                ->paginate(15);
    }

    return new MemorexCollection($memorex);	

});


Route::get('/memorex/{order_by?}/{order?}', function($order_by='id',$order='desc') {

  if ($order_by == 'riferimento') 
    {
    $memorex = Memorex::select('tblScadenzeMemorex.*')
                      ->where('completato', 0)
                      ->notHM()
                      ->with('commerciale')
                      ->leftJoin('tblCommercialiMemorex', 'tblCommercialiMemorex.id', '=', 'tblScadenzeMemorex.commerciale_id')
                      ->orderBy('tblCommercialiMemorex.nome',$order)
                      ->paginate(15);
    } 
  else 
    {
	  $memorex = Memorex::notHM()
                ->where('completato', 0)
                ->orderBy($order_by,$order)
                ->paginate(15);
    }

	return new MemorexCollection($memorex);	

});






Route::delete('memorex/{id}', function ($id) {
  $memorex = Memorex::find($id);

  return $memorex->delete();


});



//FINE MEMOREX//