<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PackagingActivity;
use App\Product;
use App\Packaging;
use App\ProductActivity;
use App\ProductStock;
use App\PackagingStock;

class PackagingActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packagingactivity = PackagingActivity::all();
        $no = 1;
        return view('produksi.kegiatan.packaging.index', compact('no','packagingactivity') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prd = Product::all();
        $poprd = ProductActivity::all();
        $pckg = Packaging::all();
        return view('produksi.kegiatan.packaging.create', compact('prd','poprd','pckg') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek = DB::table('packaging_activities')
        ->where('activity_code',$request->activity_code)
        ->count();
        
        if($cek > 0){
            return redirect()
                ->route('activity_packaging.create')
                ->with('error','Code Already Exists!!');
        }

        $stocks = DB::table('product_stocks')->where('product_id', $request->input('product_id'))->sum('production_quantity');
        
        if (!empty($stocks)) {
            if ($stocks == 0) {
                return redirect()->back()->with('error','Production Quantity is '.$stocks.'. Not Enough To Create Data');
            }
            else if($request->ruahan <= $stocks && $request->ruahan <= $request->production_result){
                
                $xx = DB::table('products')->where('id',$request->product_id)->first();
                $stock = DB::table('packaging_stocks')->where('packaging_id', $xx->id_packaging)->sum('quantity');
                
                if($stock - $request->input('used_quantity')>=0){
                    PackagingActivity::create($request->all());
                    if (!empty($stock)) {
                        PackagingStock::where('packaging_id', $xx->id_packaging)
                        ->update([
                        'quantity' => $stock - $request->input('used_quantity'),
                        ]);
                    }
                }else{
                    return redirect()->back()->with('error','Packaging Quantity is '.$stock.'. Not Enough To Create Data');
    
                }
                
                ProductStock::where('product_id', $request->input('product_id'))
                ->update([
                    'production_quantity' => $stocks - $request->input('ruahan'),
                ]);

            }else{
                if($request->ruahan > $stocks){
                    return redirect()->back()->with('error','Ruahan Melebihi Production Quantity');
                }
                else if($request->ruahan > $request->production_result){
                    return redirect()->back()->with('error','Ruahan quantity Melebihi Production  '.$request->ruahan.'. Not Enough To Create Data');
                }
            }
        
        }
        else{
            return redirect()->back()->with('error','Produk Tidak Tersedia');
        }
        
        return redirect()
            ->route('activity_packaging.create')
            ->with('success','Successfully Created');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
