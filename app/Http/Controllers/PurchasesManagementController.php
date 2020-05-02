<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Purchases;
use App\Purchase;
use App\PurchaseDetail;
use App\PoMaterial;

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
        return view('inventory.penerimaan.materials.index', ['purchases' => $purchase, 'no' => 1]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $poMaterial = PoMaterial::orderBy('id', 'desc')->get();
        return view('inventory.penerimaan.materials.create', compact('poMaterial'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek = DB::table('purchases')
        ->where('purchase_num',$request->purchase_num)
        ->count();
        
        if($cek > 0){
            return redirect('admin/purchase')->withErrors('Code Already Exists!!');
        }
        
        $purchase = Purchase::create([
            'date' => $request->date,
            'purchase_num' => $request->purchase_num,
            'delivery_orders_num' => $request->delivery_orders_num,
            'po_material_id' => $request->po_material_id,
        ]);

        $data=DB::table('po_material_details')
                ->select('materials.id','materials.material_code','materials.material_name',
                    'po_material_details.quantity')
                ->join('materials','po_material_details.material_id','=','materials.id')
                ->where('po_material_details.po_material_id',$request->po_material_id)->get();


        return redirect()
            ->route('purchases_material.index')
            ->with('success','Successfully Purchase Added');
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
        return view('inventory.penerimaan.materials.show',['purchases' => $purchase, 'purchase_view' => $purchase_view, 'no' => 1]);
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
