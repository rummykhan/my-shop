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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/category/{id}/items', 'HomeController@categoryItems')->name('category-items');

// Items Route
Route::get('/items', 'ItemController@index')->name('items-index');
Route::get('/create-item-form', 'ItemController@createItemForm')->name('create-item-form');
Route::post('/create-item', 'ItemController@createItem')->name('create-item');

Route::get('/{id}/edit-item', 'ItemController@editItem')->name('edit-item');
Route::post('/{id}/update-item', 'ItemController@updateItem')->name('update-item');

Route::post('/export-to-csv', 'ItemController@exportToCsv')->name('export-to-csv');
Route::post('/export-to-excel', 'ItemController@exportToExcel')->name('export-to-excel');

// Category Route
Route::resource('category', 'CategoryController');


Route::get('/seller/login', 'SellerController@login')->name('seller-login');
Route::post('/seller/login', 'SellerController@authenticate')->name('seller-authenticate');
Route::post('/seller/logout', 'SellerController@logout')->name('seller-logout');

Route::get('/customer/login', 'CustomerController@login')->name('customer-login');
Route::post('/customer/login', 'CustomerController@authenticate')->name('customer-authenticate');
Route::post('/customer/logout', 'CustomerController@logout')->name('customer-logout');
