<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/profile/login', 'API\AuthController@login');
Route::post('/profile/register', 'API\AuthController@register');


Route::middleware('auth:api')->group(function () {
    Route::post('/profile/detail', 'API\AuthController@get_user_details_info');
});

/*
 * Get goods without authorization
 */
Route::post('/goodsList', 'API\GoodsController@goodsList')
    ->name('goodsListPost')->middleware(['checkGoodsParameters']);
/*
 * Get detail info about good
 */
Route::post('/productDetail','API\GoodsController@good')->middleware(['checkGoodsParameters']);

/*
 * Get categories without authorization
 */
Route::post('/categoryMap', 'API\CategoriesController@getMap')
    ->name('categoryMap');

