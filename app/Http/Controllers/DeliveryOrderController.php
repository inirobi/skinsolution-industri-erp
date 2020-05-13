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
        $inv = DeliveryOrder::findOrFail($id);
        $product = Product::where('customer_id', $inv->customer_id)->get();
        $delivery_order_view = DeliveryOrderDetail::where('delivery_order_id', $id)->get();
        return view('pemesanan.delivery_order.view', compact('inv', 'delivery_order_view', 'product'));
    }

    public function viewStore(Request $request)
    {
        $leftover =DB::table('products')
            ->select('leftover.quantity')
            ->join('leftover','products.id','=','leftover.pro_id')
            ->join('delivery_orders','delivery_orders.po_product_id','=','leftover.po_id')
            ->where([
                ['leftover.pro_id',$request->product_id],
                ['delivery_orders.id',$request->delivery_order_id],
            ])->sum('quantity');
        $stocks = ProductStock::where('product_id', $request->input('product_id'))->first();
        if (!empty($stocks)) {
            if($request->quantity > $leftover){
                return redirect()
                    ->route('delivery_order.show',$request->delivery_order_id)
                    ->with('error','Quantity Melebihi Leftover');
            }
            else if($request->quantity <= $stocks->labelling_quantity){
                DB::table('products')
                ->select('leftover.quantity')
                ->join('leftover','products.id','=','leftover.pro_id')
                ->join('delivery_orders','delivery_orders.po_product_id','=','leftover.po_id')
                ->where([
                    ['leftover.pro_id',$request->product_id],
                    ['delivery_orders.id',$request->delivery_order_id],
                ])->update([
                        'quantity' => $leftover - $request->quantity,
                    ]);
                DeliveryOrderDetail::create($request->all());
                ProductStock::where('product_id', $request->input('product_id'))
                ->update([
                    'labelling_quantity' => $stocks->labelling_quantity - $request->input('quantity'),
                ]);
                return redirect()
                    ->route('delivery_order.show',$request->delivery_order_id)
                    ->with('success','Successfully DeliveryOrder Created');
            }else{
                 return redirect()
                    ->route('delivery_order.show',$request->delivery_order_id)
                    ->with('error','Quantity Melebihi Labelling Quantity');
            }
        }
        else{
            return redirect()
                ->route('delivery_order.show',$request->delivery_order_id)
                ->with('error','Produk Tidak Tersedia');
        }
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

    public function Print($id)
    {
        $inv = DeliveryOrder::findOrFail($id);
        $delivery_order_view = DeliveryOrderDetail::where('delivery_order_id', $id)->get();
        $po=DB::table('delivery_order_details')
                ->select('delivery_orders.id','delivery_order_details.delivery_order_id','delivery_order_details.product_id','products.product_name',
                    'delivery_order_details.quantity', 'delivery_order_details.created_at', 'delivery_orders.created_at')
                ->join('delivery_orders','delivery_order_details.delivery_order_id','=','delivery_orders.id')
                ->join('products','delivery_order_details.product_id','=','products.id')
                ->where('delivery_orders.po_product_id', '=', $inv->po_product_id)
                ->where('delivery_orders.created_at', '<', $inv->created_at)->get();

        $poProduct = PoProductDetail::where('po_product_id', $inv->po_product_id)->get();
        return view('pemesanan.delivery_order.print', compact('inv', 'delivery_order_view','po','id','poProduct'));
    }
}
