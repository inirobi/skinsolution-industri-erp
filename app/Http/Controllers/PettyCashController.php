<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Petty;
use App\PettyCash;
use Carbon\Carbon;

class PettyCashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petty =Petty::orderBy('id', 'desc')->get();
        $no = 1;
        return view('accounting.cash_flow.index', compact('petty','no'));
    }

    public function index2()
    {
        $petty =PettyCash::orderBy('id', 'desc')->get();
        $no = 1;
        return view('accounting.petty_cash.index', compact('petty','no'));
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
        try{
            $saldo=0;
            $sald =Petty::orderBy('id','DESC')->limit(1)->first();
            $saldo=($sald==null)?0:intval($sald->saldo);
            if($request->status=='1'){
                $saldo= $saldo+$request->money;
            }else{
                $saldo= $saldo-$request->money;
            }
            //$data->saldo;
                $petty= new Petty;
                $petty->date = $request->date;
                $petty->money = $request->money;
                $petty->status = $request->status;
                $petty->saldo = $saldo;
                $petty->keterangan = $request->keterangan;
                $petty->save();
            return redirect()
                ->route('petty.index')
                ->with('success','Successfully Cash Flow Added');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('petty.index')
                ->with('error', 'Data is not found.');
        }
    }
    public function store2(Request $request)
    {
        try{
            $sald =PettyCash::orderBy('id','DESC')->limit(1)->first();
            $saldo=($sald==null)?0:intval($sald->saldo);
            if($request->status=='1'){
                $saldo= $saldo+$request->money;
            }else{
                $saldo= $saldo-$request->money;
            }
                $petty= new PettyCash;
                $petty->date = $request->date;
                $petty->money = $request->money;
                $petty->status = $request->status;
                $petty->saldo = $saldo;
                $petty->keterangan = $request->keterangan;
                $petty->save();
            return redirect()
                ->route('petty_cash.index2')
                ->with('success','Successfully Patty Cash Added');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('petty_cash.index2')
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

    public function bayar()
    {
        
        $now = date('m/d/Y H:i', strtotime('now'));

        $lain =DB::table('po_lain')
        ->select('po_lain.*','suppliers.supplier_name','po_lain_details.quantity','po_lain_details.price','po_lain_details.nama_barang')
        ->join('suppliers','suppliers.id','=','po_lain.supplier_id')
        ->join('po_lain_details','po_lain.id','=','po_lain_details.polain_id')
        ->where([
            ['po_lain.tempo','>',$now],
            ['po_lain.status','Unpaid']
        ])->get();
        
        $pack = DB::table('po_packagings')
        ->select('po_packagings.*','suppliers.supplier_name','po_packaging_details.quantity','po_packaging_details.price','packagings.packaging_name')
        ->join('suppliers','suppliers.id','=','po_packagings.supplier_id')
        ->join('po_packaging_details','po_packaging_details.po_packaging_id','=','po_packagings.id')
        ->join('packagings','po_packaging_details.packaging_id','=','packagings.id')
        ->where([
            ['po_packagings.tempo','>',$now],
            ['po_packagings.status','Unpaid']
        ])->get();
        
        $mat = DB::table('po_materials')
        ->select('po_materials.*','suppliers.supplier_name','po_material_details.quantity','po_material_details.price','materials.material_name')
        ->join('suppliers','suppliers.id','=','po_materials.supplier_id')
        ->join('po_material_details','po_material_details.po_material_id','=','po_materials.id')
        ->join('materials','po_material_details.material_id','=','materials.id')
        
        ->where([
            ['po_materials.tempo','>',$now],
            ['po_materials.status','Unpaid']
        ])->get();
        
            $no = 1;
        return view('accounting.notif_bayar_po.index', compact('mat','lain','pack','no'));
    }

    public function laba(Request $request)
    {
        if(empty($request->date)){
            return view('laporan.laba.index');
        }else{
            $awal = new Carbon($request->date);
            $aw= $awal->format('m/d/Y');
            $akhir=  new Carbon($request->date2);
            $akh= $akhir->format('m/d/Y');
            $akhir->addDays(1);
             $ak= $akhir->format('m/d/Y');
             $masuk =Petty::whereBetween('date', [$aw, $ak])->where('status','1')->get();
            $kel =Petty::whereBetween('date', [$aw, $ak])->where('status','0')->get();
            return view('laporan.laba.index',compact('kel','masuk','aw','akh'));
        }
    }
}
