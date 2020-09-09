<?php

use App\Memorex;
use App\Http\Resources\MemorexCollection;
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
	$memorex = Memorex::orderBy('id','desc')->limit(15)->get();
	return new MemorexCollection($memorex);	
});