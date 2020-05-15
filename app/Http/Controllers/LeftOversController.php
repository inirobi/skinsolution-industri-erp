<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\PoProduct;
class LeftOversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 0){
            $po = DB::table('customers')        
                ->join('po_products','customers.id','po_products.customer_id')   
                ->get();
        }elseif(Auth::user()->role == 8){
            $po = DB::table('customers')        
                ->join('po_products','customers.id','po_products.customer_id')   
                ->where('customers.id',Auth::user()->email)   
                ->get();
        }
        return view('pemesanan.left_overs.index', compact('po'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invs = DB::table('leftover')->select('leftover.*','products.product_name')->join('products','products.id','=','leftover.pro_id')->where('po_id',$id)->count();
        if($invs == 0){
            $inv =DB::table('po_product_details')->select('po_product_details.*','products.product_name')->join('products','products.id','=','po_product_details.product_id')->where('po_product_details.po_product_id',$id)->get();
        }
        else{ 
            $inv =DB::table('leftover')->select('leftover.*','products.product_name')->join('products','products.id','=','leftover.pro_id')->where('po_id',$id)->get();
        }
        $no = 1;
        $po =PoProduct::find($id);
        return view('pemesanan.left_overs.view', compact('inv','po','invs','no'));
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
