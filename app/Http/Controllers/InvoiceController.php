<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Invoice;
use App\InvoiceDetail;
use App\Customer;
use App\PoCustomer;
use App\NotifInvo;
use App\Product;
use App\PoProduct;
use App\PoProductDetail;
use App\Petty;
use App\TrxPoProduct;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Mail;
use App\Providers\Item;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inv = DB::table('invoices')
            ->select('invoices.id as xx','customers.customer_name','po_products.po_num','invoices.*')
            ->join('customers','invoices.customer_id','customers.id')
            ->join('po_products','invoices.po_product_id','po_products.id')
            ->join('po_product_details','po_products.id','po_product_details.po_product_id')
            ->where('jenis_po','=','produksi')
            ->groupBy('invoices.id')
            ->get();
        $inv2 = DB::table('invoices')
            ->select('invoices.id as xx','customers.customer_name','po_customers.po_num','invoices.*')
            ->join('customers','invoices.customer_id','customers.id')
            ->join('po_customers','invoices.po_product_id','po_customers.id')
            ->join('po_customer_details','po_customers.id','po_customer_details.po_customer_id')
            ->where('jenis_po','=','trial')
            ->groupBy('invoices.id')
            ->get();
            
        $customer = Customer::all();
        $po = PoProduct::All();
        $not=NotifInvo::All();

        $no = 1;
      return view('accounting.pemasukan.invoice.index', compact('customer','not','po','inv','po','inv2','no'));
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

    public function xx(Request $request)
    {
        $req = $request->all();
        // echo '<pre>';
        // var_dump($req);die;
        if($request->jenis_po=="trial"){
            $data=DB::table('po_customers')
                    ->select('po_customers.id as xxx','po_num')
                    ->where('customer_id',$request->customer_id)->get();
                return ($data);
        }
        // elseif($request->jenis_po=="produksi"){
        else{
            $data=DB::table('customers')
                    ->select('customers.*','po_products.*')
                    ->join('po_products','po_products.customer_id','=','customers.id')
                    ->selectRaw('po_products.id as xxx')
                    ->where('customers.id',$request->customer_id)->get();
            return ($data);
        }
    }

}
