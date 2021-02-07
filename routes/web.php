<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');
Route::post('/login','AuthController@login')->name('login.submit');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/dashboard','DashboardController@index')->name('dashboard');
    Route::get('logout', 'AuthController@logout')->name('logout');
    Route::resource('/admin/satuan', 'SatuanController');
    Route::resource('/admin/barang', 'BarangController');
    Route::resource('/admin/supplier', 'SupplierController');
});
