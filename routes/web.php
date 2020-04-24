<?php

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
    return view('validasi');
});


Route::get('/home', 'HomeController@index');
Route::get('/error', 'HomeController@error');

// bahan baku
Route::resource('/materials', 'MaterialsController');
//suplier
Route::resource('/suppliers', 'SuppliersController');

// penggajian
Route::get('/pegawai', 'PenggajianController@pegawai');
Route::get('/gaji', 'PenggajianController@gaji');

// Route Transaksi Pemesanan
Route::get('/pemesanan/customer', 'TransaksiPemesananController@customer');
