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

Route::get('/create-item-form', 'ItemController@createItemForm')->name('create-item-form');
Route::post('/create-item', 'ItemController@createItem')->name('create-item');

Route::get('/{id}/edit-item', 'ItemController@editItem')->name('edit-item');
Route::post('/{id}/update-item', 'ItemController@updateItem')->name('update-item');
