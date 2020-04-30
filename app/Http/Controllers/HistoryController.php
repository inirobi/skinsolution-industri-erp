<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DeliveryOrder;
use App\DeliveryOrderDetail;
use App\Customer;
use App\Product;
use App\PoProduct;
use App\PoProductDetail;
use App\Stock;
class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no = 1;
        $po = PoProduct::All();
        return view('pemesanan.history.index', compact('no','po'));
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
        $inv = DB::table('po_product_details')->select('po_product_details.*','products.*')->join('products','products.id','=','po_product_details.product_id')->where('po_product_details.po_product_id',$id)->get();
        $po = PoProduct::findOrFail($id);
        $no = 1;
        return view('pemesanan.history.view', compact('inv','po','no'));
    }

    public function detail($id,$po_id)
    {
        $inv = DB::table('delivery_orders')->select('delivery_orders.*','delivery_order_details.*')->join('delivery_order_details','delivery_orders.id','=','delivery_order_details.delivery_order_id')->where('delivery_orders.po_product_id',$po_id)->where('delivery_order_details.product_id',$id)->get();
        $pro = Product::findOrFail($id);
        $no = 1;
        return view('pemesanan.history.detail',  compact('inv','pro','no' ));
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
