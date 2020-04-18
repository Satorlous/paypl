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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'SiteController@index')
    ->name('index');
Route::get('/test', 'SiteController@test')
    ->name('test');

Route::post('/goodsList', 'GoodsController@goodsList')
    ->name('goodsListPost')->middleware(['checkGoodsParameters']);
Route::get('/categoryMap', 'CategoriesController@getMap')
    ->name('categoryMap');

Route::get('/home',function () {
    return redirect('/');
});

Route::get('/profile','ProfileController@profile')->name('profile');
Route::get('/profile/statistics','ProfileController@profileStatistics');
Route::get('/profile/pay-services','ServicesController@payServices');
Route::get('/profile/contact-services','ServicesController@contactServices');

Route::get('/profile/goods','GoodsController@goodsUser');
Route::get('/profile/orders','GoodsController@ordersUser');

Route::get('/category/{id}','ServicesController@category');
Route::get('/category/{idC}/subcategory/{id}','ServicesController@subcategory');
Route::get('/category/{idC}/subcategory/{idSC}/goods/{id}','GoodsController@goodsDetail');

/**
 * Только для админов
 */
Route::get('/statuses','ServicesController@statuses');
Route::get('/roles','ServicesController@roles');

