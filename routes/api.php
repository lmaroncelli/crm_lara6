<?php

use App\Http\Resources\MemorexCollection;
use App\Memorex;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
	$memorex = Memorex::notHM()->orderBy('id','desc')->paginate(15);
	return new MemorexCollection($memorex);	
});

Route::get('/memorex/riferimenti', function(){
	$riferimenti = User::commerciale()->pluck('name','id')->toArray();
	return $riferimenti;	
});

Route::get('memorex/{id}', function ($id) {
    $memorex = Memorex::find($id);
    
    try {
    	$memorex->data = Carbon::createFromFormat('Y-m-d', $memorex->data)->format('d/m/Y');
    } catch (\Exception $e) {
          // do nothing	
    }
    
    return $memorex;
});


Route::patch('memorex/{id}', function(Request $request, $id) {
		$data_arr = $request->get('data');
    Memorex::findOrFail($id)
    					->update([
    						'titolo' => $data_arr['titolo'],
    						'descrizione' => $data_arr['descrizione'],
    						'data' => Carbon::createFromFormat('d/m/Y', $data_arr['data'])->format('Y-m-d'),
    						'categoria' => $data_arr['categoria'],
    						'riferimento' => $data_arr['riferimento']
    					]);
});

