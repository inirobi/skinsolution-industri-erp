<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Purchases;
use App\PurchaseDetail;

class PurchasesManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase = DB::table('purchases')
        ->select('purchases.*','po_materials.po_num')
        ->join('po_materials','purchases.po_material_id','po_materials.id')
        ->orderBy('purchases.id', 'desc')->get();
        return view('inventory.bahan_baku.purchases', ['purchases' => $purchase, 'no' => 1]);
    }

    public function indexPurchases()
    {
        $purchase = DB::table('purchases')
        ->select('purchases.*','po_materials.po_num')
        ->join('po_materials','purchases.po_material_id','po_materials.id')
        ->orderBy('purchases.id', 'desc')->get();
        return view('inventory.bahan_baku.purchases', ['purchases' => $purchase, 'no' => 1]);
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
        $purchase = Purchases::findOrFail($id);
        $purchase_view= DB::table('purchase_details')
        ->select('materials.material_name','purchase_details.*')
        ->leftJoin('materials','materials.id','=','purchase_details.material_id')
        ->where('purchase_details.purchase_id',$id)->get();
        return view('inventory.bahan_baku.purchasesShow',['purchases' => $purchase, 'purchase_view' => $purchase_view, 'no' => 1]);
    }

    public function showPurchases($id)
    {
        $purchase = Purchases::findOrFail($id);
        $purchase_view= DB::table('purchase_details')
        ->select('materials.material_name','purchase_details.*')
        ->leftJoin('materials','materials.id','=','purchase_details.material_id')
        ->where('purchase_details.purchase_id',$id)->get();
        return view('inventory.bahan_baku.purchasesShow',['purchases' => $purchase, 'purchase_view' => $purchase_view, 'no' => 1]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        try {
            PurchaseDetail::whereId($id)->delete();
            return redirect()->back()->with('success', 'Successfully Deleted.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('purchases.index')
                ->with('error', 'Data is not found.');
          }
    }

    public function destroyPurchases($id)
    {
        //
        try {
            PurchaseDetail::whereId($id)->delete();
            return redirect()->back()->with('success', 'Successfully Deleted.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect('purchases_penerimaan')
                ->with('error', 'Data is not found.');
          }
    }
}
