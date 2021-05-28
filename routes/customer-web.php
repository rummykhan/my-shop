<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'customer', 'middleware' => 'customer-guest'], function () {
    Route::get('/login', 'CustomerController@login')->name('customer-login');
    Route::post('/login', 'CustomerController@authenticate')->name('customer-authenticate');
});


Route::group(['prefix' => 'customer', 'middleware' => 'customer'], function () {
    Route::get('/profile', fn() => 'Customer Profile')->name('customer-profile');

    Route::post('/logout', 'CustomerController@logout')->name('customer-logout');
});
