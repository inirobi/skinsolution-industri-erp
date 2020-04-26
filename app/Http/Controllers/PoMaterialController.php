<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PoMaterial;
use App\PoMaterialDetail;
use App\Suppliers;
use App\Materials;
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
        // echo "<pre>";
        // var_dump($purchases[0]->supplier_name);
        // echo "<hr>";
        // var_dump($purchases);
        // echo "</pre>";die;
        return view('inventory.purchases.po_materials.detail',['purchases' => $purchases, 'id' => $id ]);
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
}
