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
            ->orderBy('invoices.updated_at','desc')
            ->get();
        $inv2 = DB::table('invoices')
            ->select('invoices.id as xx','customers.customer_name','po_customers.po_num','invoices.*')
            ->join('customers','invoices.customer_id','customers.id')
            ->join('po_customers','invoices.po_product_id','po_customers.id')
            ->join('po_customer_details','po_customers.id','po_customer_details.po_customer_id')
            ->where('jenis_po','=','trial')
            ->groupBy('invoices.id')
            ->orderBy('invoices.updated_at','desc')
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
        $cek = DB::table('invoices')
        ->where('invoice_num',$request->invoice_num)
        ->count();
        
        if($cek > 0){
            return redirect()
                ->route('invoice.index')
                ->with('success','Code Already Exists!!');
        }
        
        $saldo=0;
        $sald =Petty::orderBy('id','DESC')->limit(1)->get();
        foreach($sald as $data){
          $data->saldo;
        }
         if($request->status=='1'){
          $saldo= $data->saldo-$request->money;
         }else{
          $saldo= $data->saldo+$request->money;
         }
        if($request->terms=='Cash'){
            $status='Paid';
        }else{
            $status='Unpaid';
        } 
        
        $invoice=new Invoice();
        $invoice->invoice_num=$request->invoice_num;
        $invoice->jenis_invoice=$request->jenis_invoice;
        $invoice->jenis_po=$request->jenis_po;
        $invoice->dp=$request->dp;
        $invoice->customer_id=$request->customer_id;
        $invoice->po_product_id=$request->po_product_id;
        $invoice->shipped=$request->shipped;
        $invoice->fob=$request->fob;
        $invoice->terms=$request->terms;
        $invoice->status=$status;
        $invoice->date=$request->date;
        $invoice->save();
        
        return redirect()
            ->route('invoice.index')
            ->with('success','Successfully Invoice Created');
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
        $inv = Invoice::findOrFail($id);
        
        if($inv->jenis_po == "trial"){
            $total=0;
            $invs= DB::table('invoices')
            ->select('invoices.*','po_customer_details.po_customer_id','customers.customer_name','po_customers.po_num')
            ->join('customers','invoices.customer_id','customers.id')
            ->join('po_customers','invoices.po_product_id','po_customers.id')
            ->join('po_customer_details','po_customers.id','po_customer_details.po_customer_id')
            ->where('invoices.id',$id)
            ->first();
            $invo = DB::table('invoice_details')->where('invoice_id', $id)->get();
            $podetail=DB::table('po_customer_details')->where('po_customer_id', $inv->po_product_id)->get();
            
            foreach($podetail as $d){
                $total+=($d->pack * $d->quantity);
            }
    
          return view('accounting.pemasukan.invoice.view2',compact('invs','total','podetail','invo'));
        }
        elseif($inv->jenis_po == "produksi"){
            
            $total=0;
            $xx = InvoiceDetail::where('invoice_id', $id)->count();
            $product = Product::where('customer_id', $inv->customer_id)->get();
            $invo = InvoiceDetail::where('invoice_id', $id)->get();
            
            $po = PoProduct::findOrFail($inv->po_product_id);       
            $pack=DB::table('products')
            ->join('po_product_details','products.id','=','po_product_details.product_id')
            ->join('packagings','products.id_packaging','=','packagings.id')
            ->where([
                ['po_product_details.po_product_id',$inv->po_product_id],
                ['po_product_details.packaging','=','1'],
            ])
            ->groupby('packagings.id')
            ->get();
            
            $lab=DB::table('products')
            ->join('po_product_details','products.id','=','po_product_details.product_id')
            ->join('packagings','products.id_labelling','=','packagings.id')
            ->where([
                ['po_product_details.po_product_id',$inv->po_product_id],
                ['po_product_details.labelling','=','1'],
            ])
            ->groupby('packagings.id')
            ->get();
            $customer = Customer::all();
                $podetail=PoProductDetail::where('po_product_id', $inv->po_product_id)->groupby('product_id')->get();
            foreach($podetail as $d){
                $total+=($d->quantity * $d->product->sale_price);
            }
            foreach($invo as $dt){
                $total+=($dt->quantity * $dt->price);
            }
            foreach($pack as $dt1){
                $total+=($dt1->quantity * $dt1->price);
            }
    
          return view('accounting.pemasukan.invoice.view', compact('xx','inv', 'invo', 'product','po','podetail','customer','pack','lab','total'));
        }
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
        $pod=PoProductDetail::where('po_product_id',$request->po_product_id)->get();
        
        if($request->status=='Paid'){
         $saldo=0;
        $sald =Petty::orderBy('id','DESC')->limit(1)->get();
        foreach($sald as $d){
          $d->saldo;
        }
          $saldo= $d->saldo-$request->money;
        
        $petty=new Petty();
        $now=new Carbon(now());
        $petty->date=$now->format('m/d/Y');
        $petty->money=$request->money;
        $petty->saldo= $saldo;
        $petty->status='0';
        $petty->keterangan="Invoice";
        $petty->save();
        }
        if($request->jenis_invoice == "dp" && $request->jenis_dp == "persen" || $request->jenis_invoice == "nondp" && $request->jenis_dp == "persen"){
            Invoice::whereId($id)
                ->update([
                    'jenis_invoice' => $request->jenis_invoice,
                    'dp' => $request->dpPersen,
                    'jenis_dp' => $request->jenis_dp,
                    'shipped' => $request->shipped,
                    'fob' => $request->fob,
                    'status' => $request->status,
                ]);
        }
        else if($request->jenis_invoice == "dp" && $request->jenis_dp == "rupiah" || $request->jenis_invoice == "nondp" && $request->jenis_dp == "rupiah"){
            Invoice::whereId($id)
                ->update([
                    'jenis_invoice' => $request->jenis_invoice,
                    'dp' => $request->dpRupiah,
                    'jenis_dp' => $request->jenis_dp,
                    'shipped' => $request->shipped,
                    'fob' => $request->fob,
                    'status' => $request->status,
                ]);
        }
        else if($request->jenis_invoice == "other"){
            Invoice::whereId($id)
                ->update([
                    'jenis_invoice' => $request->jenis_invoice,
                    'dp' => " ",
                    'jenis_dp' =>" ",
                    'shipped' => $request->shipped,
                    'fob' => $request->fob,
                    'status' => $request->status,
                ]);
        }
        
        if($request->jenis_invoice=='nondp'){
            foreach($pod as $data){
                $invdet=new TrxPoProduct();
                $invdet->po_product_id= $data->po_product_id;
                $invdet->product_id= $data->product_id;
                $invdet->quantity= $data->quantity;
                $invdet->pack= $data->pack;
                $invdet->packaging= $data->packaging;
                $invdet->labelling= $data->labelling;
                $invdet->save();
            }
        }
        return redirect()
            ->route('invoice.edit',$id)
            ->with('success','Successfully Updated');
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
        if($request->jenis_po=="trial"){
            $data=DB::table('po_customers')
                    ->select('po_customers.id as xxx','po_num')
                    ->where('customer_id',$request->customer_id)->get();
             return ($data);
        }
        elseif($request->jenis_po=="produksi"){
            $data=DB::table('customers')
                    ->select('customers.*','po_products.*')
                    ->join('po_products','po_products.customer_id','=','customers.id')
                    ->selectRaw('po_products.id as xxx')
                    ->where('customers.id',$request->customer_id)->get();
            return ($data);
        }
    }

    public function detailStore(Request $request)
    {
        
        DB::table('invoice_details')->where('invoice_id',$request->invoice_id)
        ->insert([
            'invoice_id' => $request->invoice_id,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'jenis' => $request->kurang_dp,
            'price' => $request->price,

        ]);
        return redirect()
            ->route('invoice.edit',$request->input('invoice_id'))
            ->with('success','Successfully Invoice Created');
    }

    public function ViewUpdate(Request $request,$id)
    {
       
        $invid = $request->input('id');
        $quan = $request->input('quantity');
        for($i= 0; $i < count($invid); $i++){
            TrxPoProduct::whereId($invid[$i])
            ->update([
                'quantity' => $quan[$i],
                
            ]);
        }
        return redirect()
            ->route('invoice.edit',$id)
            ->with('success','Successfully Updated');
    }

    public function detailStore2(Request $request)
    {
        DB::table('invoice_details')->where('invoice_id',$request->invoice_id)
        ->insert([
            'invoice_id' => $request->invoice_id,
            'description' => $request->description,
            'quantity' => 1,
            'jenis' => "other",
            'price' => $request->price,

        ]);
        return redirect()
            ->route('invoice.edit',$request->input('invoice_id'))
            ->with('success','Successfully Invoice Created');
    }


}
