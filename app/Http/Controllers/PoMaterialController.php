<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PoMaterial;
use App\PoMaterialDetail;
use App\Suppliers;
use App\Material;
use App\NotifMaterials;
use App\MaterialSupplier;
use App\Petty;
use Illuminate\Support\Facades\DB;

class PoMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase= DB::table('po_materials')
        ->select('po_materials.*','suppliers.supplier_name')
        ->join('suppliers','suppliers.id','=','po_materials.supplier_id')
        ->orderBy('po_materials.id', 'desc')->get();
        $supplier = Suppliers::all();
        return view('inventory.purchases.po_materials.index', ['purchase' =>$purchase,'supplier' => $supplier, 'no'=>1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.purchases.po_materials.create');
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
        $purchases = DB::table('po_material_details')
                ->select('po_materials.*', 'suppliers.supplier_name','materials.id', 'materials.material_code', 'materials.material_name', 'po_material_details.quantity', 'po_material_details.price')
                ->join('po_materials','po_materials.id', '=', 'po_material_details.po_material_id') 
                ->join('materials','materials.id', '=', 'po_material_details.material_id') 
                ->join('material_suppliers','material_suppliers.id', '=', 'materials.id')
                ->join('suppliers','suppliers.id', '=', 'material_suppliers.supplier_id')
                ->where('po_material_details.po_material_id',$id)
                ->get();
        $materials = Materials::all();
        return view('inventory.purchases.po_materials.detail',['purchases' => $purchases, 'id' => $id, 'materials' => $materials ]);
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
        echo $id."<br>";
        var_dump($request);die;

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

    public function pengeluaran_material()
    {
        // $purchase = PoMaterial::orderBy('id', 'desc')->get();
        $purchase = DB::table('po_materials')
                    ->select('po_materials.*','suppliers.supplier_name') 
                    ->join('suppliers','po_materials.supplier_id','=','suppliers.id')
                    ->orderBy('po_materials.id','desc')
                    ->get();
        // $supplier = Suppliers::all();
         // $notifmat=NotifMaterials::all();
        // return view('accounting.pengeluaran.material.index', compact('purchase','supplier'));
        return view('accounting.pengeluaran.material.index', compact('purchase'));
    }
    public function pengeluaran_material_detail($id)
    {
        $purchase = DB::table('po_material_details')
                    ->join('materials','po_material_details.material_id','=','materials.id')
                    ->join('po_materials','po_material_details.po_material_id','=','po_materials.id')
                    ->join('suppliers', 'po_materials.supplier_id','=','suppliers.id')
                    ->where('po_materials.id', $id)
                    ->get();
     
        return view('accounting.pengeluaran.material.view', ['purchase'=>$purchase]);
    }
    public function pengeluaran_material_update(Request $request)
    {
        try {
            DB::table('po_materials')
              ->where('id', $request->kode)
              ->update(['status' => $request->status]); 
          
          return redirect('accounting_POmaterial')
              ->with('success', 'Successfully Updated.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect('accounting_POmaterial')
              ->with('error', 'Data is not found.');
        }
    }
}
