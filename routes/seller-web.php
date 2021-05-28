<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'seller', 'middleware' => 'seller-guest'], function () {
    Route::get('/login', 'SellerController@login')->name('seller-login');
    Route::post('/login', 'SellerController@authenticate')->name('seller-authenticate');
});

Route::group(['prefix' => 'seller', 'middleware' => 'seller'], function () {

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

    Route::post('/logout', 'SellerController@logout')->name('seller-logout');
});
