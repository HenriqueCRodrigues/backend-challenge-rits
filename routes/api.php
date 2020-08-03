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

Route::prefix('customers')->group(function () {
    Route::post('create', 'CustomerController@store');

    Route::prefix('{customerId}')->group(function () {
        Route::prefix('orders')->group(function () {
            Route::post('create', 'OrderController@storeFromCustomer');
            Route::get('orders', 'OrderController@allFromCustomer');
            Route::prefix('{orderId}')->group(function () {
                Route::get('show', 'OrderController@showFromCustomer');
                Route::put('cancel', 'OrderController@cancelFromCustomer');
                Route::delete('delete', 'OrderController@deleteFromCustomer');
            });
        });
    });
});


Route::prefix('')->group(function () {
    Route::prefix('products')->group(function () {
        Route::post('create', 'ProductController@store');
        Route::get('products', 'ProductController@all');
        Route::put('update', 'ProductController@update');
        Route::delete('delete', 'ProductController@delete');
    });
    
    Route::prefix('orders')->group(function () {
        Route::get('', 'OrderController@all');
        Route::prefix('{orderId}')->group(function () {
            Route::put('change-status', 'OrderController@changeStatus');
            Route::delete('delete', 'OrderController@delete');
        });
    });
});