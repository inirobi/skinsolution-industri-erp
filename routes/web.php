<?php
use App\PoMaterialDetail;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Input;
use App\PoProduct;

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

Route::get('/material/kontradiksi/{id}', 'MaterialsController@kontradiksiShow')->name('material.kontradiksi.show');
Route::get('/material/kontradiksi', 'MaterialsController@kontradiksiStore')->name('material.kontradiksi.store');
Route::delete('/material/kontradiksi/{id}', 'MaterialsController@kontradiksiDelete')->name('material.kontradiksi.delete');

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
Route::post('/packaging_receipt/storeCS', 'PackagingReceiptController@storeCS')->name('packaging_receipt.storeCS');
Route::get('/packaging_receipt/showSS/{id}', 'PackagingReceiptController@viewAddSS')->name('packaging_receipt.showSS');
Route::post('/packaging_receipt/view/storess/', 'PackagingReceiptController@ViewStorAjax')->name('packaging_receipt.view.store.ss');
Route::get('/packaging_receipt/view/add/ajax-state/{id}',function($id)
    {
        // $po_packaging_id = Input::get("po_packaging_id");
        $data=DB::table('po_packaging_details')
                ->select('packagings.id','packagings.packaging_code','packagings.packaging_name',
                    'po_packaging_details.quantity')
                ->join('packagings','po_packaging_details.packaging_id','=','packagings.id')
                ->where('po_packaging_details.po_packaging_id',$id)->get();
        return $data;

    });

//purchases
Route::resource('/purchases_material', 'PurchasesManagementController');
Route::get('/purchase/add/ajax-state/{id}',function($id)
{
    // $po_material_id = Input::get("po_material_id");
    $data=DB::table('po_material_details')
            ->select('materials.id','materials.material_code','materials.material_name',
                'po_material_details.quantity')
            ->join('materials','po_material_details.material_id','=','materials.id')
            ->where('po_material_details.po_material_id',$id)->get();
    //$subcategories= Supplier::where('id',$categories->supplier_id)->get();
    return $data;

});

//po material
Route::resource('/po_material', 'PoMaterialController'); 
Route::post('/po_material/view/store/', 'PoMaterialController@ViewStore')->name('po_material.viewStore');
Route::delete('/po_material/view/destroy/{id}', 'PoMaterialController@destroyView')->name('po_material.destroyView');
//po packaging
Route::resource('/po_packaging', 'PoPackagingController'); 
Route::post('/po_packaging/view/store/', 'PoPackagingController@ViewStore')->name('po_packaging.viewStore');
Route::delete('/po_packaging/view/destroy/{id}', 'PoPackagingController@destroyView')->name('po_packaging.destroyView');

//===============end inventory===================


//==========pemesanan====================//
//purchase Order
    //=>product
Route::resource('/po_product_pemesanan', 'PoProductController');
Route::delete('/po_product_pemesanan/view/destroy/{id}', 'PoProductController@viewDestroy')->name('po_product_pemesanan.viewDestroy');
Route::post('/po_product_pemesanan/view/store', 'PoProductController@viewStore')->name('po_product_pemesanan.viewStore');
 
    //=>Trial
Route::resource('/po_customer', 'PoCustomerController');
Route::delete('/po_customer/view/destroy/{id}', 'PoCustomerController@viewDestroy')->name('po_customer.viewDestroy');
Route::post('/po_customer/view/store', 'PoCustomerController@viewStore')->name('po_customer.viewStore');
    
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

//invoice
Route::resource('/invoice', 'InvoiceController');
Route::get('/invoice/xx', 'InvoiceController@xx')->name('invoice.xx');
Route::get('/invoice/state', 'InvoiceController@state')->name('invoice.state');

//notifikasi pembayaran invoice
Route::get('/bayar/notif', 'PettyCashController@bayar')->name('bayar.notif_po');
Route::resource('/petty', 'PettyCashController');

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
//=>packaging
Route::resource('/activity_packaging', 'PackagingActivityController');
//=>product
Route::resource('/activity_product', 'ProductActivityController');
Route::get('/activity_product/view_sub/{id}/{product_id}', 'ProductActivityController@ViewSub')->name('product_activity.viewsub');
Route::post('/product_activity/view/store/ajax-state', 'ProductActivityController@ViewStoreAjax')->name('product_activity.view.store');
Route::get('/product_activity/view/add/{id}', 'ProductActivityController@ViewAdd')->name('activity_product.view.add');
Route::get('/product_activity/view/add/ajax-state/{id}',function($id)
{
    $a=DB::table('products')
            ->select('materials.id','materials.material_name',
                        'formula_details.quantity','formula_details.weighing')
            ->join('formulas','products.formula_id','=','formulas.id')
            ->join('formula_details','formula_details.formula_id','=','formulas.id')
            ->join('materials','formula_details.material_id','=','materials.id')
            ->where('products.id',$id)
            ->where('formula_details.source_material',1)
            ->orderBy('materials.material_name', 'ASC')->get();

    $b=DB::table('products')
            ->select('sample_materials.id','sample_materials.material_name',
                        'formula_details.quantity','formula_details.weighing')
            ->join('formulas','products.formula_id','=','formulas.id')
            ->join('formula_details','formula_details.formula_id','=','formulas.id')
            ->join('sample_materials','formula_details.material_id','=','sample_materials.id')
            ->where('products.id',$id)
            ->where('formula_details.source_material',0)
            ->orderBy('sample_materials.material_name', 'ASC')->get();

    //$subcategories= Supplier::where('id',$categories->supplier_id)->get();
    return $a->merge($b);
});

Route::get('/product_activity/view/store/data-checker/{id}',function($id)
{
    $a=DB::table('products')
            ->select('materials.id','materials.material_name',
                        'stocks.quantity','formula_details.weighing')
            ->join('formulas','products.formula_id','=','formulas.id')
            ->join('formula_details','formula_details.formula_id','=','formulas.id')
            ->join('materials','formula_details.material_id','=','materials.id')
            ->join('stocks','stocks.material_id','=','materials.id')
            ->where('products.id',$id)
            ->where('formula_details.source_material',1)
            ->orderBy('materials.material_name', 'ASC')->get();

    $b=DB::table('products')
            ->select('sample_materials.id','sample_materials.material_name',
                        'sample_stocks.quantity','formula_details.weighing')
            ->join('formulas','products.formula_id','=','formulas.id')
            ->join('formula_details','formula_details.formula_id','=','formulas.id')
            ->join('sample_materials','formula_details.material_id','=','sample_materials.id')
            ->join('sample_stocks','sample_stocks.sample_material_id','=','sample_stocks.id')
            ->where('products.id',$id)
            ->where('formula_details.source_material',0)
            ->orderBy('sample_materials.material_name', 'ASC')->get();

    //$subcategories= Supplier::where('id',$categories->supplier_id)->get();
    return $a->merge($b);

});

//retur
Route::resource('/retur', 'ReturController');
Route::get('/retur/add/ajax-state/{id}',function($id)
{
    $subcategories=DB::table('po_product_details')  
        ->select('po_products.*','po_product_details.*','products.*')          
        ->join('products','products.id','po_product_details.product_id')
        ->join('po_products','po_products.id','po_product_details.po_product_id')
        ->selectRaw('products.id as xx')
        ->where('po_products.id',$id)->get();

        return $subcategories;
});

//formula
Route::resource('/formula', 'FormulaController');

//trial
Route::resource('/trial', 'TrialDataController');

//trial revisi
Route::resource('/trial_revisi', 'TrialRevisionDataController');

//=================Laporan=====================
Route::get('/laporanPengeluaran', 'LaporanController@pengeluaran')->name('laporan.pengeluaran');
Route::post('/laporanStorePengeluaran', 'LaporanController@storePengeluaran')->name('laporan.store.pengeluaran');