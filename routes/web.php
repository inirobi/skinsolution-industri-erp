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

//purchases
Route::resource('/purchases', 'PurchasesManagementController');
Route::get('/purchases_penerimaan','PurchasesManagementController@indexPurchases');
Route::get('/purchases_penerimaan/view/{id}','PurchasesManagementController@showPurchases');
Route::delete('/purchases_penerimaan/view/{id}','PurchasesManagementController@destroyPurchases');

//po material
Route::resource('/po_material', 'PoMaterialController'); 

//===============end inventory===================


//==========pemesanan====================//

//packaging
Route::resource('/customers', 'CustomersController');

//Delivery Order
Route::resource('/delivery_order', 'DeliveryOrderController');

//left_overs
Route::resource('/left_overs', 'LeftOversController');

//==========pemesanan====================//
// penggajian
Route::get('/pegawai', 'PenggajianController@pegawai');
Route::get('/gaji', 'PenggajianController@gaji');

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

//==================accounting==============
//pengeluaran_material
Route::get('/pengeluaran_material', 'PoMaterialController@pengeluaran_material');
Route::put('/pengeluaran_material', 'PoMaterialController@pengeluaran_material_update');
Route::get('/pengeluaran_material/view/{id}', 'PoMaterialController@pengeluaran_material_detail');

//pengeluaran packaging
Route::get('/pengeluaran_packaging', 'PoPackagingController@pengeluaran_packaging');
Route::put('/pengeluaran_packaging', 'PoPackagingController@packaging_update');
Route::get('/pengeluaran_packaging/view/{id}', 'PoPackagingController@packaging_View');

//pengeluarn lain-lain
Route::resource('/pengeluaran_lain', 'PoLainController');
Route::post('/pengeluaran_lainView','PoLainController@ViewStore');
Route::delete('/pengeluaran_lainDestroy/{id}','PoLainController@ViewDestroy');

//pengeluaran gaji
Route::resource('/pengeluaran_gaji', 'PengeluaranGajiController');