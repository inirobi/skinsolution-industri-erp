<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliveryOrder;
use App\DeliveryOrderDetail;
use App\Customer;
use App\Product;
use App\PoProduct;
use App\PoProductDetail;
use App\ProductStock;
use Illuminate\Support\Facades\DB;
class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inv = DeliveryOrder::orderBy('id', 'desc')->get();
        return view('pemesanan.delivery_order.index', compact('inv'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = Customer::all();
        $po = PoProduct::all();
        return view('pemesanan.delivery_order.create',compact('customer','po'));
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
            'delivery_order_num' => 'required',
        ]);
        try {
            $cek = DB::table('delivery_orders')
                ->where('delivery_order_num',$request->delivery_order_num)
                ->count();
                
                if($cek > 0){
                    return redirect()
                      ->route('delivery_order.index')
                      ->with('error', 'Code Already Exists!!');
                }

                DeliveryOrder::create($request->all());
            return redirect()
              ->route('delivery_order.index')
              ->with('success', 'Successfully Updated.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
              ->route('delivery_order.index')
              ->with('error', 'Data is not found.');
        }
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
        $inv = DeliveryOrder::findOrFail($id);
        $customer = Customer::all();
        $po = PoProduct::all();
        return view('pemesanan.delivery_order.create', compact('inv','customer','po'));
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
        $this->validate($request,[
            'delivery_order_num' => 'required',
        ]);
        try {
            DeliveryOrder::whereId($id)
            ->update([
                'delivery_order_num' => $request->delivery_order_num,
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'po_product_id' => $request->po_product_id,
            ]);
         return redirect()
              ->route('delivery_order.index')
              ->with('success', 'Successfully Updated.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
              ->route('delivery_order.index')
              ->with('error', 'Data is not found.');
        }
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
            DeliveryOrder::whereId($id)->delete();
         return redirect()
              ->route('delivery_order.index')
              ->with('success', 'Successfully Updated.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
              ->route('delivery_order.index')
              ->with('error', 'Data is not found.');
        }
    }
}
