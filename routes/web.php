<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('login');
})->name('login');
Route::post('/login','AuthController@login')->name('login.submit');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/dashboard','DashboardController@index')->name('dashboard');
    Route::get('logout', 'AuthController@logout')->name('logout');
    Route::group(['middleware' => 'manager'], function() {
        Route::resource('/admin/satuan', 'SatuanController');
        Route::resource('/admin/barang', 'BarangController');
        Route::resource('/admin/supplier', 'SupplierController');
        Route::resource('/admin/kantor', 'KantorController');
        Route::resource('/admin/pengguna', 'PenggunaController');
    });
    Route::group(['middleware' => 'staff'], function() {
        Route::resource('/admin/barangmasuk', 'BarangMasukController');
        Route::resource('/admin/barangkeluar', 'BarangKeluarController');
        Route::get('/admin/kartu-stok', 'KartustokController@index')->name('kartu.index');
        Route::post('/admin/kartu-stok', 'KartustokController@search')->name('kartu.search');
        Route::get('/admin/kartu-stok/{id}/{dari}/{sampai}/pdf', 'KartustokController@pdf')->name('kartu.pdf');
    });
});
