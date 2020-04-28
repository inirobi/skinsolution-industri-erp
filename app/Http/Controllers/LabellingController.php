<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Packaging;
use App\PackagingStock;
use App\ProductStock;
use App\PackagingActivity;
use App\Labelling; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LabellingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no = 1;
        $labellings = DB::table('labellings')->select('labellings.*','packaging_activities.activity_code')->join('packaging_activities','packaging_activities.id','labellings.packaging_activity_id')->orderby('packaging_activities.id','ASC')->get();
        return view('produksi.kegiatan.labelling.index', compact('labellings','no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $no = 1;
        $pckg = DB::table('packaging_activities')->where('status','Release')->get();
        return view('produksi.kegiatan.labelling.create', compact('pckg','no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek = DB::table('labellings')
        ->where('labelling_code',$request->labelling_code)
        ->count();
        
        if($cek > 0){
            return redirect()
            ->route('labelling.create')
            ->with('error', 'Code Already Exists!!');
        }
        
        $xx = DB::table('packaging_activities')->join('products','packaging_activities.product_id','products.id')
        ->where('packaging_activities.id',$request->packaging_activity_id)->first();
        
       $stocks = DB::table('packaging_stocks')->where('packaging_id', $xx->id_labelling)->sum('quantity');
       
       $product_stocks = DB::table('product_stocks')->join('packaging_activities','packaging_activities.product_id','product_stocks.product_id')
       ->where('packaging_activities.id',$request->packaging_activity_id)
       ->sum('packaging_quantity');

                
        if (!empty($stocks)) {
            if ($stocks == 0 || $product_stocks == 0 || $xx->packaging_result == 0) {
                return redirect()->back()>with('error','Data Kosong');
            }
            else if($request->result <= $xx->packaging_result ){
                
                if($request->used_quantity <= $stocks ){
                    
                    if($request->input('used_packaging') <= $product_stocks){
                        Labelling::create($request->all());
                        if (!empty($stocks)) {
                            PackagingStock::where('packaging_id', $xx->id_labelling)
                            ->update([
                            'quantity' => $stocks - $request->input('used_quantity'),
                            ]);
                            
                            
                            ProductStock::where('product_id', $xx->product_id)
                            ->update([
                                'packaging_quantity' => $product_stocks - $request->used_packaging,
                            ]);
                        }
                    }else{
                        return redirect()->back()->with('error', 'Use Packaging Melebihi Packaging Stock');
        
                    }
                
                }else{
                     return redirect()->back()->with('error','Use Quantity Melebihi Packaging Quantity');
                }   
            }else{
                 return redirect()->back()->with('error','Labelling Result Melebihi Packaging Result');
            } 
            
        }
        else{
            return redirect()->back()->with('error','Packaging Tidak Tersedia');
        }

        return redirect()->route('labelling.index')->with('success','Successfully Created');
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
        try {
            Labelling::whereId($id)->delete();
            return redirect()->back()->with('success', 'Successfully Deleted.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('materials.index')
                ->with('error', 'Data is not found.');
          } 
    }
}
