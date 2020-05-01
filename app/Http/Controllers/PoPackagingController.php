<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PoPackaging;
use Carbon\Carbon;
use App\PoPackagingDetail;
use App\Petty;
use App\Packaging;
use App\Suppliers;

class PoPackagingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase = PoPackaging::orderBy('id', 'desc')->get();
        $no = 1;
        return view('inventory.purchases.po_packaging.index', compact('purchase','no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = Suppliers::all();
        return view('inventory.purchases.po_packaging.create',compact('supplier'));
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
            'po_num' => 'required',
            'date' => 'required',
            'supplier_id' => 'required',
            'terms' => 'required',
        ]);
        try{
            $cek = DB::table('po_packagings')
        ->where('po_num',$request->po_num)
        ->count();
            
            if($cek > 0){
                return redirect()
                    ->route('po_packaging.index')
                    ->withErrors('Code Already Exists!!');
            }
            $date = explode('/',$request->date);
            $date = $date[2]."-".$date[0]."-".$date[1];

            date_default_timezone_set('Asia/Jakarta');   
            if($request->terms == "7 Days"){
                $tempo = date('m/d/Y ', strtotime('+1 friday', strtotime($date)));    
            }
            else if($request->terms == "14 Days"){
                $tempo = date('m/d/Y', strtotime('+2 friday', strtotime($date)));    
            }
            else if($request->terms == "30 Days"){
                $tempo = date('m/d/Y', strtotime('+4 friday', strtotime($date)));die;
            }
            else if($request->terms == "Cash"){
                $tempo = "00-00-0000";
            }
            
            if($request->terms=='Cash'){
                $status='Paid';
                $petty=new Petty();
                $petty->date= $date;
                $petty->money='0';
                $petty->status='0';
                $petty->saldo='0';
                $petty->keterangan='Pembayaran PO Packaging';
                $petty->save();
            }else{
                $status='Unpaid';
            }
            $PoPackaging=new PoPackaging();
            $PoPackaging->po_num=$request->po_num;
            $PoPackaging->supplier_id=$request->supplier_id;
            $PoPackaging->po_date=$date;
            $PoPackaging->tempo=$tempo;
            $PoPackaging->ppn=$request->ppn;
            $PoPackaging->terms=$request->terms;
            $PoPackaging->status=$status;
            $PoPackaging->save();
            
            return redirect()
                ->route('po_packaging.index')
                ->with('success','Successfully PurchaseOrder Packaging Added');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
              ->route('po_packaging.index')
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
        $purchase = PoPackaging::findOrFail($id);
        $packaging = Packaging::where('supplier_id', $purchase->supplier_id)->get();
        $purchase_view = PoPackagingDetail::where('po_packaging_id', $id)->get();
        
        return view('inventory.purchases.po_packaging.detail',compact('purchase','packaging','purchase_view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = PoPackaging::findOrFail($id);
        $supplier = Suppliers::all();
        return view('inventory.purchases.po_packaging.create', compact('purchase','supplier'));
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
            'po_num' => 'required',
            'date' => 'required',
        ]);
        try {
            $date = explode('/',$request->date);
            $date = $date[2]."-".$date[0]."-".$date[1];

            PoPackaging::whereId($id)
            ->update([
                'po_num' => $request->po_num,
                'po_date' => $date,
                'terms' => $request->terms,
                'supplier_id' => $request->supplier_id,
                'ppn' => $request->ppn,
            ]);
          
          return redirect()
            ->route('po_packaging.index')
            ->with('success', 'Successfully Updated.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
            ->route('po_packaging.index')
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
            PoPackagingDetail::where('po_packaging_id',$id)->delete();
            PoPackaging::whereId($id)->delete();
            return redirect()
                ->route('po_packaging.index')
                ->with('success','Successfully Purchase Order Delete');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('po_packaging.index')
                ->with('error', 'Data is not found.');
        }
    }

    public function destroyView($id)
    {
        try{
            $purchase = PoPackagingDetail::findOrFail($id);
            PoPackagingDetail::whereId($id)->delete();
            return redirect()
                ->route('po_packaging.show',$purchase->po_packaging_id)
                ->with('success','Successfully PurchaseOrder Delete');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('po_packaging.index')
                ->with('error', 'Data is not found.');
            }
    }

    public function ViewStore(Request $request)
    {
        PoPackagingDetail::create($request->all());
        $popack = PoPackaging::find($request->po_packaging_id);
        if($popack->status=='Paid'){
            $poPackagingdetail = PoPackagingDetail::where('po_packaging_id', $request->po_packaging_id)->get(); 
            $total = ($request->quantity * $request->price);
            $PPN = 0;
            if(!empty($poPackagingdetail)){
                $total = 0;
                foreach ($poPackagingdetail as $dataDetail) {
                    $total = $total + ($dataDetail->quantity * $dataDetail->price);
                }
            }
            $PPN = 0.10 * $total;
            if($popack->ppn=='1'){
                $total = $total + $PPN;
            }
         
            $petty=Petty::where('date',$popack->po_date)->get();
            foreach($petty as $dd){
                $dd->date= $popack->po_date;
                $dd->money=$total;
                $dd->status='0';
                $dd->saldo='0';
                $dd->keterangan='Pembayaran PO Packaging';
                $dd->update();
            }

        }
      return redirect()
        ->route('po_packaging.show',$request->input('po_packaging_id'))
        ->with('success','Successfully PurchaseOrder Added');
   
    }

    public function pengeluaran_packaging()
    {
        $purchase = PoPackaging::orderBy('id', 'desc')->get();
        return view('accounting.pengeluaran.packaging.index', compact('purchase'));
    }

    public function packaging_update(Request $request)
    {
        $id=$request->kode;
        PoPackaging::whereId($id)
        ->update([
            'status' => $request->status,
            ]);
        if($request->status=='Paid'){
            $popack = PoPackaging::find($id);
            $poPackagingdetail = PoPackagingDetail::where('po_packaging_id', $id)->get(); 
            $total = 0;
            $PPN = 0;
            foreach ($poPackagingdetail as $dataDetail) {
                $total = $total + ($dataDetail->quantity * $dataDetail->price);
            }

            $PPN = 0.10 * $total;
            if($popack->ppn=='1'){
            $total = $total + $PPN;
            }
            $mytime = Carbon::now();
            $petty=new Petty();
            $petty->date= $mytime->format('m/d/Y h:i A');
            $petty->money=$total;
            $petty->status='0';
            $petty->saldo='0';
            $petty->keterangan='Pembayaran PO Packaging';
            $petty->save();

        }
       return redirect('accounting_POpackaging')->with('success', 'Successfully Updated.');
    }

    public function packaging_View($id)
    {
        $purchase = PoPackaging::findOrFail($id);
        //$packaging = Packaging::all();
        $packaging = Packaging::where('supplier_id', $purchase->supplier_id)->get();
        $purchase_view = PoPackagingDetail::where('po_packaging_id', $id)->get();
        return view('accounting.pengeluaran.packaging.view', compact('purchase', 'purchase_view', 'packaging'));
    }
}
