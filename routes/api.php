<?php

use App\Good;
use App\Order;
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
    Route::post('/profile/detail', 'API\AuthController@get_users_details_info');
    /*
     * CRUD
     */
    Route::post('/goods/store', 'API\GoodsDataController@store');
    Route::post('/goods/update', 'API\GoodsDataController@update');
    Route::post('/goods/destroy', 'API\GoodsDataController@destroy');
    Route::post('/goods/restore', 'API\GoodsDataController@restore');
    Route::post('/goods/owner','API\GoodsDataController@goodsListByOwner');

    Route::post('/users/update', 'API\UsersDataController@update');
    Route::post('/users/destroy', 'API\UsersDataController@destroy');
    Route::post('/users/restore', 'API\UsersDataController@restore');
    Route::post('/users/chart', 'API\UsersDataController@profit_chart');

    Route::post('/orders/buyer', 'API\OrdersDataController@orderListByBuyer');
    Route::post('/orders/owner', 'API\OrdersDataController@orderListByGoodOwner');
    Route::post('/orders/store', 'API\OrdersDataController@store');
    Route::post('/orders/update', 'API\OrdersDataController@update');
    Route::post('/orders/destroy', 'API\OrdersDataController@destroy');
    Route::post('/orders/payment', 'API\OrdersDataController@payment');
    Route::post('/orders/retry_payment', 'API\OrdersDataController@retry_payment');

    Route::post('/request/get', 'API\RequestController@get');
    Route::post('/request/store', 'API\RequestController@store');
    Route::post('/request/update', 'API\RequestController@update');
});

/*
 * Get goods without authorization
 */
Route::post('/goodsList', 'API\GoodsController@goodsList')
    ->name('goodsListPost')->middleware(['checkGoodsParameters']);
/*
 * Get detail info about good
 */
Route::post('/productDetail', 'API\GoodsController@good')->middleware(['checkGoodsParameters']);

/*
 * Get categories without authorization
 */
Route::post('/categoryMap', 'API\CategoriesController@getMap')
    ->name('categoryMap');

Route::post('/category', 'API\CategoriesController@getCategory')
    ->middleware(['checkCategoryParameters']);

Route::get('/catalog/{slug}', 'API\CategoriesController@getBreadcrumbs');
Route::get('/catalog', 'API\CategoriesController@getBreadcrumbs');
Route::get('/catalog/{slug}/{product}', 'API\CategoriesController@getBreadcrumbs');

