<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PoPackaging;
use Carbon\Carbon;
use App\PoPackagingDetail;
use App\Petty;
use App\Packaging;

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
