<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::prefix('customers')->group(function () {
        Route::get('', 'CustomerController@webAll')->name('web.customers.all');
        Route::get('create', 'CustomerController@webCreateCustomer')->name('web.customers.create');
        Route::post('store', 'CustomerController@webStoreCustomer')->name('web.customers.store');
        Route::get('{customerId}/edit', 'CustomerController@webEditCustomer')->name('web.customers.edit');
        Route::post('{customerId}/update', 'CustomerController@webUpdateCustomer')->name('web.customers.update');
        Route::delete('{customerId}/delete', 'CustomerController@webDeleteCustomer')->name('web.customers.delete');

    });

    Route::prefix('products')->group(function () {
        Route::get('', 'ProductController@webAll')->name('web.products.all');
        Route::get('create', 'ProductController@webCreateProduct')->name('web.products.create');
        Route::post('store', 'ProductController@webStoreProduct')->name('web.products.store');
        Route::get('{productId}/edit', 'ProductController@webEditProduct')->name('web.products.edit');
        Route::post('{productId}/update', 'ProductController@webUpdateProduct')->name('web.products.update');
        Route::delete('{productId}/delete', 'ProductController@webDeleteProduct')->name('web.products.delete');
    });

    Route::prefix('orders')->group(function () {
        Route::get('', 'OrderController@webAll')->name('web.orders.all');
        Route::get('{orderId}/edit', 'OrderController@webEditProduct')->name('web.orders.edit');
        Route::post('{orderId}/status', 'OrderController@webStatusOrder')->name('web.orders.status');
        Route::delete('{orderId}/delete', 'OrderController@webDeleteProduct')->name('web.orders.delete');
    });

});
