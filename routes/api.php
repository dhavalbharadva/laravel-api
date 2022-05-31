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

Route::post('login', 'API\LoginController@login');
Route::post('register', 'API\UserController@store');


Route::group(['middleware' => 'auth:api'], function(){
    
    Route::get('profile', 'API\UserController@index');
    Route::post('profile', 'API\UserController@update');
    
    #logout user
    Route::get('logout', 'API\LoginController@logout');
    
    #order
    Route::get('orders', 'API\OrderController@getOrders');
    Route::get('orders/delayed', 'API\OrderController@getDelayedOrders');
    Route::post('order/store', 'API\OrderController@store');
    Route::put('order/update-status', 'API\OrderController@updateStatus');

});
