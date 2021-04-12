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
Route::get('/category/{id}/{slug}', 'HomeController@categoryItems')->name('category-items');

Route::resource('category', 'CategoryController');
Route::resource('item', 'ItemController');

Route::post('/export-to-csv', 'ItemController@exportToCsv')->name('export-to-csv');
Route::post('/export-to-excel', 'ItemController@exportToExcel')->name('export-to-excel');

