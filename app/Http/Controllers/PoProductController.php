<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Customer;
use App\PoProduct;
use App\PoProductDetail;
use App\Product;

class PoProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no = 1;
        $customer = Customer::all();
        $popro=DB::table('po_products')->select('po_products.*','customers.customer_name')->join('customers','customers.id','=','po_products.customer_id')->orderBy('po_products.id', 'desc')->get();
        return view('pemesanan.po.produksi.index', compact('popro','customer','no'));
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
        try {
            if ($request->po_num == '' || $request->date == '' || $request->customer_id == '') {
                return redirect()
                ->route('po_customer.index')
                ->with('error', 'Incorect Value.');
            }

            $cek = DB::table('po_products')
                ->where('po_num',$request->po_num)
                ->count();
            
            if($cek > 0){
                return redirect()
                    ->route('po_product_pemesanan.index')
                    ->with('error','Code Already Exists!!');
            }
            
            PoProduct::create($request->all());
          return redirect()
            ->route('po_product_pemesanan.index')
              ->with('success', 'Successfully PurchaseOrder Added.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
            ->route('po_product_pemesanan.index')
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
        $purchase = PoProduct::findOrFail($id);
        $purchase_view = PoProductDetail::where('po_product_id', $id)->get();
        $product = Product::where('customer_id', $purchase->customer_id)->get();
        return view('pemesanan.po.produksi.view', compact('purchase','purchase_view','product'));
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
        try {
            if ($request->po_num == '' || $request->date == '' || $request->customer_id == '' || $request->date_end == '') {
                return redirect()
                ->route('po_product_pemesanan.index')
                ->with('error', 'Incorect Value.');
            }

            PoProduct::whereId($id)
            ->update([
                'po_num' => $request->po_num,
                'customer_id' => $request->customer_id,
                'date' => $request->date,
                'date_end' => $request->date_end,
            ]);
          return redirect()
            ->route('po_product_pemesanan.index')
              ->with('success', 'Successfully PurchaseOrder Updated.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
            ->route('po_product_pemesanan.index')
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
        try{
            DB::table('po_product_details')
                ->where('po_product_id',$id)
                ->delete();
                PoProduct::whereId($id)->delete();
            return redirect()
                ->route('po_product_pemesanan.index')
                ->with('success', 'Successfully PurchaseOrder Delete.');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('po_product_pemesanan.index')
                ->with('error', 'Data is not found.');
        }
    }

    public function viewStore(Request $request)
    {
        try{
            PoProductDetail::create($request->all());
            DB::table('leftover')
                ->insert([
                    'po_id' => $request->po_product_id,
                    'pro_id' => $request->product_id,
                    'quantity' => $request->quantity,
                ]);
            return redirect()
                ->route('po_product_pemesanan.show',$request->input('po_product_id'))
                ->with('success', 'Successfully PurchaseOrder Added.');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('po_product_pemesanan.show',$request->input('po_product_id'))
                ->with('error', 'Data is not found.');
        }
    }

    public function viewDestroy($id)
    {
        try{
            $purchase = PoProductDetail::findOrFail($id);
            PoProductDetail::whereId($id)->delete();
            return redirect()
                ->route('po_product_pemesanan.show',$purchase->po_product_id)
                ->with('success', 'Successfully PurchaseOrder Delete.');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('po_product_pemesanan.index')
                ->with('error', 'Data is not found.');
        }
    }
}
