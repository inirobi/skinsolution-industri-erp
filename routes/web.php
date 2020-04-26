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
    return view('auth.login');
});


Route::get('/home', 'HomeController@index');
Route::get('/error', 'HomeController@error');

//===============inventory===================

// bahan baku
Route::resource('/materials', 'MaterialsController');
Route::get('/materials_stocks', 'MaterialsController@dataStock');
Route::get('/material/supplier', 'MaterialsController@supplierStore');
Route::delete('/material/supplier/{id}', 'MaterialsController@SupplierDelete');

//suplier
Route::resource('/suppliers', 'SuppliersController');

//SOF Rout Packagings
//packaging
Route::resource('/packagings', 'PackagingsController');
Route::get('/packagings_stocks', 'PackagingsController@dataStock');
Route::get('/packagings/customer/ajax', 'PackagingsController@customerState');
Route::get('/packagings/supplier/ajax', 'PackagingsController@supplierState');
Route::get('/packagings/all/ajax', 'PackagingsController@getAllPackagingsData');
Route::get('/packagings/customers/ajax', 'PackagingsController@getCustomersPackagingsData');
Route::get('/packagings/suppliers/ajax', 'PackagingsController@getSuppliersPackagingsData');
//EOF Route Packagings

//principals
Route::resource('/principals', 'PrincipalsController');
Route::get('/principal/supplier', 'PrincipalsController@supplierStore');
Route::delete('/principal/supplier/{id}', 'PrincipalsController@SupplierDelete');

//samples
Route::resource('/samples', 'SamplesController');
Route::get('/samples_stocks', 'SamplesController@dataStock');

//===============end inventory===================


//==========pemesanan====================//

//packaging
Route::resource('/customers', 'CustomersController');



//==========pemesanan====================//
// penggajian
Route::get('/pegawai', 'PenggajianController@pegawai');
Route::get('/gaji', 'PenggajianController@gaji');

// Route Transaksi Pemesanan
Route::get('/pemesanan/customer', 'TransaksiPemesananController@customer');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
