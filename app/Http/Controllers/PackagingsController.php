<?php

namespace App\Http\Controllers;

use App\Packagings;
use App\Customers;
use App\Suppliers;
use App\Packaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackagingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $packagings = Packagings::orderBy('id', 'desc')->get();
        $pck = DB::table('packagings')->get();
        return view('inventory.packagings.index', ['datas'=> $packagings, 'no'=>1,'pck'=> $pck]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.packagings.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'packaging_code' => 'required',
            'category' => 'required',
            'packaging_name' => 'required',
            'packaging_type' => 'required',
            'stock_minimum' => 'required',
            'category' => 'required',
            'price' => 'required'
        ]); 
  
        try {
            $req = $request->all();
            if($req['packaging_type']=='CS'){
                Packagings::create([
                    'id' => null,
                    'packaging_code' => $req['packaging_code'],
                    'category' => $req['category'],
                    'packaging_name' => $req['packaging_name'],
                    'packaging_type' => $req['packaging_type'],
                    'stock_minimum' => $req['stock_minimum'],
                    'customer_id' => $req['vendor'],
                    'category' => $req['category'],
                    'price' => $req['price'],
                    'status' => 'Pending',
                  ]);
            }else{
                Packagings::create([
                    'id' => null,
                    'packaging_code' => $req['packaging_code'],
                    'category' => $req['category'],
                    'packaging_name' => $req['packaging_name'],
                    'packaging_type' => $req['packaging_type'],
                    'stock_minimum' => $req['stock_minimum'],
                    'supplier_id' => $req['vendor'],
                    'category' => $req['category'],
                    'price' => $req['price'],
                    'status' => 'Pending',
                  ]);
            }
          return redirect()
              ->route('packagings.index')
              ->with('success', 'Data berhasil disimpan.');
        }catch(Exception $e){
          return redirect()
              ->route('packagings.create')
              ->with('error', $e->toString());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Packagings  $packagings
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Packaging::findOrFail($id);
            return view('inventory.packagings.detail', ['data' => $data]);
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('packagings.index')
                ->with('error', 'Data tidak ditemukan.');
          }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Packagings  $packagings
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Packagings::findOrFail($id);
            return view('inventory.packagings.create', ['data' => $data]);
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('packagings.index')
                ->with('error', 'Data tidak ditemukan.');
          }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Packagings  $packagings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'packaging_code' => 'required',
            'category' => 'required',
            'packaging_name' => 'required',
            'packaging_type' => 'required',
            'stock_minimum' => 'required',
            'category' => 'required',
            'price' => 'required'
        ]); 

        try {
            $req = $request->all();
            $packagings = Packagings::findOrFail($id);
            if($req['packaging_type']=='CS'){
                $packagings -> packaging_code = $req['packaging_code'];
                $packagings -> category = $req['category'];
                $packagings -> packaging_name = $req['packaging_name'];
                $packagings -> packaging_type = $req['packaging_type'];
                $packagings -> stock_minimum = $req['stock_minimum'];
                $packagings -> customer_id = $req['vendor'];
                $packagings -> category = $req['category'];
                $packagings -> price = $req['price'];
                $packagings -> status = 'Pending';
            }else{
                $packagings -> packaging_code = $req['packaging_code'];
                $packagings -> category = $req['category'];
                $packagings -> packaging_name = $req['packaging_name'];
                $packagings -> packaging_type = $req['packaging_type'];
                $packagings -> stock_minimum = $req['stock_minimum'];
                $packagings -> supplier_id = $req['vendor'];
                $packagings -> category = $req['category'];
                $packagings -> price = $req['price'];
                $packagings -> status = 'Pending';
            }
            $packagings->save();
            return redirect()
              ->route('packagings.index')
              ->with('success', 'Data berhasil diperbarui.');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('packagings.index')
              ->with('error', 'Data tidak ditemukan.');
        }
    }

    public function print($id)
    {
        //MASUK
        
        $packaging = Packaging::findOrFail($id);
        $recept =DB::table('packaging_receipts as a')
        ->select('a.receipt_code','b.*')
        ->join('packaging_receipt_details as b','a.id','=','b.packaging_receipt_id')
        ->where('b.packaging_id',$id)->get();
        
        $retur = DB::table('products')
        ->select('retur.tanggal_retur','retur.quantity_retur','packagings.packaging_code')
        ->join('retur','products.id','retur.fk_kode_produk')
        ->join('packagings','products.id_packaging','packagings.id')
        ->where('products.id_packaging',$id)
        ->get();
        
        $sum1 = DB::table('products')
        ->select('retur.tanggal_retur','retur.quantity_retur','packagings.packaging_code')
        ->join('retur','products.id','retur.fk_kode_produk')
        ->join('packagings','products.id_packaging','packagings.id')
        ->where('products.id_packaging',$id)
        ->sum('quantity_pack');
    
        $sum2=DB::table('packaging_receipts as a')
        ->select('a.receipt_code','b.*')
        ->join('packaging_receipt_details as b','a.id','=','b.packaging_receipt_id')
        ->where('b.packaging_id',$id)->sum('quantity');
        
        //KELUAR
        
        $activity = DB::table('products')
        ->join('packaging_activities','products.id','packaging_activities.product_id')
        ->join('packagings','products.id_packaging','packagings.id')
        ->where([
            ['packaging_activities.status','=','Release'],
            ['packagings.id',$id]
        ])->get();
        
        $pack = DB::table('pengeluaran_packaging')->where('packaging_id',$id)->get();
        
        $sum3 = DB::table('products')
        ->join('packaging_activities','products.id','packaging_activities.product_id')
        ->join('packagings','products.id_packaging','packagings.id')
        ->where([
            ['packaging_activities.status','=','Release'],
            ['packagings.id',$id]
        ])->sum('used_quantity');
        
        $sum4 = DB::table('pengeluaran_packaging')->where('packaging_id',$id)->sum('quantity');
        
        $sisa = ($sum1 + $sum2) - ($sum3 + $sum4);
        $masuk = $sum1 + $sum2;
        $keluar = $sum3 + $sum4;
        
     return view('inventory.packagings.print',compact('packaging','recept','retur','activity','pack','sisa','masuk','keluar'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Packagings  $packagings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Packagings::findOrFail($id)->delete();
            return redirect()
                ->route('packagings.index')
                ->with('success', 'Data telah di hapus.');
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('packagings.index')
                ->with('error', 'Data tidak ditemukan.');
          }
    }
    
    /**
     * State Ajax of Customer
     * 
     * @return JSON
     */
    public function customerState()
    {
        return Customers::select('customers.id','customers.customer_name')->get();
    }

    /**
     * State Ajax of Supplier
     * 
     * @return JSON
     */
    public function supplierState()
    {
        return Suppliers::select('suppliers.id','suppliers.supplier_name')->get();
    }

    /**
     * State Ajax of All Data Packaging
     * 
     * @return JSON
     */
    public function getAllPackagingsData()
    {
        DB::statement(DB::raw('set @row:=0'));
        return Packagings::select(DB::raw('@row:=@row+1 as rowNumber, packagings.id as idData'),'packagings.*','customers.*','suppliers.*')
                        ->leftJoin('customers','packagings.customer_id','=','customers.id')
                        ->leftJoin('suppliers','packagings.supplier_id','=','suppliers.id')
                        ->get();
    }

    /**
     * State Ajax of Customers Data Packaging
     * 
     * @return JSON
     */
    public function getCustomersPackagingsData()
    {
        DB::statement(DB::raw('set @row:=0'));
        return Packagings::select(DB::raw('@row:=@row+1 as rowNumber, packagings.id as idData'),'packagings.*','customers.*')
                        ->leftJoin('customers','packagings.customer_id','=','customers.id')
                        ->where('packagings.packaging_type','CS')
                        ->get();
    }

    /**
     * State Ajax of Customers Data Packaging
     * 
     * @return JSON
     */
    public function getSuppliersPackagingsData()
    {
        DB::statement(DB::raw('set @row:=0'));
        return Packagings::select(DB::raw('@row:=@row+1 as rowNumber, packagings.id as idData'),'packagings.*','suppliers.*')
                        ->leftJoin('suppliers','packagings.supplier_id','=','suppliers.id')
                        ->where('packagings.packaging_type','SS')
                        ->get();
        // return '{"data":'.Packagings::select(DB::raw('@row:=@row+1 as rowNumber'),'packagings.*','suppliers.*')
        //     ->leftJoin('suppliers','packagings.supplier_id','=','suppliers.id')
        //     ->where('packagings.packaging_type','SS')
        //     ->get().'}';
    }

    public function dataStock()
    {
        $stocks = DB::table('packaging_stocks')
            ->join('packagings', 'packaging_stocks.packaging_id', '=', 'packagings.id')
            ->select('packaging_stocks.*', 'packagings.*')
            ->orderBy('packagings.updated_at', 'desc')
            ->get();
        return view('inventory.packagings.stocks',['stocks'=> $stocks, 'no'=>1]);
    }

    public function pengeluaran_packaging()
    {
        $purchase = PoPackaging::orderBy('id', 'desc')->get();
        return view('backend.pengeluaran.packaging', compact('purchase'));
    }
}