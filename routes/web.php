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

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function(){
	Route::resource('customers', 'Customers')->only(['index']);
	Route::post('customers/getCustomers', 'Customers@getCustomers')->name('customers.getCustomers');

	Route::resource('products', 'Products')->only(['index']);
	Route::post('products/getProducts', 'Products@getProducts')->name('products.getProducts');
	Route::get('products/{product}/status', 'Products@status')->name('products.status');

	Route::resource('orders', 'Orders');
	Route::post('orders/getOrders', 'Orders@getOrders')->name('orders.getOrders');
});
