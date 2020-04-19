<?php

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


Route::get('/goods', function (Request $request) {
    header('Access-Control-Allow-Origin: *');
    //return json_encode($request);
    $r = stream_get_contents('http://localhost:3000');
    var_dump($r);
    return json_encode($r);
});
