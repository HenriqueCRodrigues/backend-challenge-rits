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
    Route::post('create', 'CustomerController@store')->name('customers.store');

    Route::prefix('{customerId}')->group(function () {
        Route::prefix('orders')->group(function () {
            Route::post('create', 'OrderController@storeFromCustomer')->name('customers.orders.create');
            Route::post('', 'OrderController@allFromCustomer')->name('customers.orders.all');
            Route::prefix('{orderId}')->group(function () {
                Route::get('show', 'OrderController@showFromCustomer')->name('customers.orders.show');
                Route::put('cancel', 'OrderController@cancelFromCustomer')->name('customers.orders.cancel');
                Route::delete('delete', 'OrderController@deleteFromCustomer')->name('customers.orders.delete');
            });
        });
    });
});


Route::middleware('auth')->group(function () {
    Route::prefix('products')->group(function () {
        Route::post('create', 'ProductController@store')->name('products.store');
        Route::post('', 'ProductController@all')->name('products.all');
        Route::put('update', 'ProductController@update')->name('products.update');
        Route::prefix('{productId}')->group(function () {
            Route::get('', 'ProductController@show')->name('products.show');
            Route::delete('delete', 'ProductController@delete')->name('products.delete');
        });

    });
    
    Route::prefix('orders')->group(function () {
        Route::post('', 'OrderController@all');
        Route::prefix('{orderId}')->group(function () {
            Route::put('change-status', 'OrderController@changeStatus')->name('orders.change');
            Route::delete('delete', 'OrderController@delete')->name('orders.delete');
        });
    });
});