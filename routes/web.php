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
Route::resource('/income_samples', 'SamplePurchaseController');

//penerimaan packaging
Route::resource('/packaging_receipt', 'PackagingReceiptController');

//purchases
Route::resource('/purchases', 'PurchasesManagementController');
Route::get('/purchases_penerimaan','PurchasesManagementController@indexPurchases');
Route::get('/purchases_penerimaan/view/{id}','PurchasesManagementController@showPurchases');
Route::delete('/purchases_penerimaan/view/{id}','PurchasesManagementController@destroyPurchases');

//po material
Route::resource('/po_material', 'PoMaterialController'); 
//po packaging
Route::resource('/po_packaging', 'PoPackagingController'); 

//===============end inventory===================


//==========pemesanan====================//

//packaging
Route::resource('/customers', 'CustomersController');

//Delivery Order
Route::resource('/delivery_order', 'DeliveryOrderController');

//left_overs
Route::resource('/left_overs', 'LeftOversController');

//history
Route::resource('/history', 'HistoryController');
Route::get('/history/detail/{id}/{po_id}', 'HistoryController@detail')->name('history.detail');

// penggajian
Route::get('/pegawai', 'PenggajianController@pegawai');
Route::get('/gaji', 'PenggajianController@gaji');

Route::get('/pemesanan/customer', 'TransaksiPemesananController@customer');

Auth::routes();

//==================accounting==============
//pengeluaran_material
Route::get('/accounting_POmaterial', 'PoMaterialController@pengeluaran_material');
Route::put('/accounting_POmaterial', 'PoMaterialController@pengeluaran_material_update');
Route::get('/accounting_POmaterial/view/{id}', 'PoMaterialController@pengeluaran_material_detail');

//pengeluaran packaging
Route::get('/accounting_POpackaging', 'PoPackagingController@pengeluaran_packaging');
Route::put('/accounting_POpackaging', 'PoPackagingController@packaging_update');
Route::get('/accounting_POpackaging/view/{id}', 'PoPackagingController@packaging_View');

//pengeluarn lain-lain
Route::resource('/pengeluaran_lain', 'PoLainController');
Route::post('/pengeluaran_lainView','PoLainController@ViewStore');
Route::delete('/pengeluaran_lainDestroy/{id}','PoLainController@ViewDestroy');

//pengeluaran gaji
Route::resource('/pengeluaran_gaji', 'PengeluaranGajiController');

//pemasukan pejualan
Route::resource('/penjualan', 'PenjualanController');


//==========================Produksi============================
Route::resource('/labelling', 'LabellingController');
Route::resource('/produksi', 'ProductController');
Route::get('/stok_produksi', 'ProductController@indexStock')->name('produksi.stoct');

//pengeluaran
Route::resource('/pengeluaran_material', 'MaterialOutController');
Route::resource('/pengeluaran_ruahan', 'RuahanOutController');
Route::resource('/pengeluaran_packaging', 'PackagingOutController');
Route::get('/pengeluaran_packaging2', 'PackagingOutController@index2')->name('pengeluaran_packaging2.index2');
Route::get('/pengeluaran_packaging2/create2', 'PackagingOutController@create2')->name('pengeluaran_packaging2.create2');
Route::post('/pengeluaran_packaging2', 'PackagingOutController@store2')->name('pengeluaran_packaging2.store2');
Route::get('/pengeluaran_packaging2/{id}/edit2', 'PackagingOutController@edit2')->name('pengeluaran_packaging2.edit2');
Route::put('/pengeluaran_packaging2/{id}', 'PackagingOutController@update2')->name('pengeluaran_packaging2.update2');

Route::resource('/pengeluaran_labelling', 'LabellingOutController');
Route::get('/pengeluaran_labelling2', 'LabellingOutController@index2')->name('pengeluaran_labelling2.index2');
Route::get('/pengeluaran_labelling2/create2', 'LabellingOutController@create2')->name('pengeluaran_labelling2.create2');
Route::post('/pengeluaran_labelling2', 'LabellingOutController@store2')->name('pengeluaran_labelling2.store2');
Route::get('/pengeluaran_labelling2/{id}/edit2', 'LabellingOutController@edit2')->name('pengeluaran_labelling2.edit2');
Route::put('/pengeluaran_labelling2/{id}', 'LabellingOutController@update2')->name('pengeluaran_labelling2.update2');


//kegiatan
Route::resource('/activity_packaging', 'PackagingActivityController');


//retur
Route::resource('/retur', 'ReturController');

//formula
Route::resource('/formula', 'FormulaController');

//trial
Route::resource('/trial', 'TrialDataController');

//trial revisi
Route::resource('/trial_revisi', 'TrialRevisionDataController');