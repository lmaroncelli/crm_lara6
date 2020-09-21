<?php

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



Route::get('/memorex', function(){
	$memorex = Memorex::notHM()
                ->where('completato', 0)
                ->orderBy('id','desc')
                ->paginate(15);

	return new MemorexCollection($memorex);	
});

Route::get('/memorex/scadute/{order_by?}/{order?}', function($order_by='id',$order='desc') {
    $memorex = Memorex::notHM()
                ->scadute()
                ->orderBy($order_by,$order)
                ->paginate(15);

    return new MemorexCollection($memorex); 
});


Route::get('/memorex/non-scadute', function(){
    $memorex = Memorex::notHM()
                ->nonScadute()
                ->orderBy('id','desc')
                ->paginate(15);

    return new MemorexCollection($memorex); 
});

Route::get('/memorex/archivio', function(){
    $memorex = Memorex::notHM()
                ->where('completato', 1)
                ->orderBy('id','desc')
                ->paginate(15);

    return new MemorexCollection($memorex); 
});




Route::get('/memorex/riferimenti', function(){
	$riferimenti = CommercialeMemorex::pluck('nome','id')
                    ->toArray();
	
    return $riferimenti;	
});

Route::get('memorex/{id}', function ($id) {
    $memorex = Memorex::find($id);

    return new MemorexResource($memorex);	

});


Route::patch('memorex/{id}', function(Request $request, $id) {
    $data_arr = $request->get('data');
    //dd($data_arr);
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


Route::get('memorex/search/{search}', function ($search) {
    $memorex = Memorex::notHM()
                        ->where('titolo','LIKE', '%'.$search.'%')
                        ->orderBy('id','desc')
                        ->paginate(15);

    //dd(Str::replaceArray('?', $memorex->getBindings(), $memorex->toSql()));

    return new MemorexCollection($memorex);	

});

