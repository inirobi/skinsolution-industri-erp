<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PoCustomer;
use App\Customer;
use App\PoCustomerDetail;
use App\Product;
use Illuminate\Support\Facades\DB;

class PoCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase = DB::table('po_customers') 
            ->select('po_customers.*','customers.customer_name')
            ->join('customers','customers.id','po_customers.customer_id')
            ->orderBy('po_customers.created_at', 'desc')
            ->get();
        $customer = Customer::all();
        $no = 1;
        return view('pemesanan.po.trial.index', compact('purchase','customer','no'));
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

            $cek = DB::table('po_customers')
            ->where('po_num',$request->po_num)
            ->count();
            
            if($cek > 0){
                return redirect()
                    ->route('po_customer.index')
                    ->with('error','Code Already Exists!!');
            }
            
            PoCustomer::create($request->all());
          return redirect()
            ->route('po_customer.index')
              ->with('success', 'Successfully PurchaseOrder Added.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
            ->route('po_customer.index')
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
        $purchase = PoCustomer::findOrFail($id);
        $product = Product::all();
        $purchase_view = PoCustomerDetail::where('po_customer_id', $id)
                        ->orderBy('updated_at', 'desc')
                        ->get();
        return view('pemesanan.po.trial.view', compact('purchase', 'purchase_view', 'product'));
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
            if ($request->po_num == '' || $request->date == '' || $request->customer_id == '') {
                return redirect()
                ->route('po_customer.index')
                ->with('error', 'Incorect Value.');
            }

            PoCustomer::whereId($id)
            ->update([
                'po_num' => $request->po_num,
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'status' => $request->status,
            ]);
          return redirect()
            ->route('po_customer.index')
              ->with('success', 'Successfully PurchaseOrder Updated.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
            ->route('po_customer.index')
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
            DB::table('po_customer_details')
                ->where('po_customer_id',$id)
                ->delete();
            PoCustomer::whereId($id)->delete();
            return redirect()
                ->route('po_customer.index')
                ->with('success', 'Successfully PurchaseOrder Delete.');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('po_customer.index')
                ->with('error', 'Data is not found.');
        }
    }

    public function viewStore(Request $request)
    {
        try{
            PoCustomerDetail::create($request->all());
            return redirect()
                ->route('po_customer.show',$request->input('po_customer_id'))
                ->with('success', 'Successfully PurchaseOrder Added.');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('po_customer.show',$request->input('po_customer_id'))
                ->with('error', 'Data is not found.');
        }
    }

    public function viewDestroy($id)
    {
        try{
            $purchase = PoCustomerDetail::findOrFail($id);
            PoCustomerDetail::whereId($id)->delete();
            return redirect()
                ->route('po_customer.show',$purchase->po_customer_id)
                ->with('success', 'Successfully PurchaseOrder Delete.');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('po_customer.index')
                ->with('error', 'Data is not found.');
        }
    }
}
