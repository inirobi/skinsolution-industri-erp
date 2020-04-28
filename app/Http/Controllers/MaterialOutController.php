<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PoMaterial;
use App\MaterialOut;
use App\PoMaterialDetail;
use App\Supplier;
use App\Material;
use App\NotifMaterials;
use App\MaterialSupplier;
use App\Stock;
use Illuminate\Support\Facades\DB;

class MaterialOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no = 1;
        $matout = MaterialOut::orderBy('id', 'desc')->get();
        return view('produksi.pengeluaran.material.index', compact('matout','no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $no = 1;
        $material = Material::all();
        return view('produksi.pengeluaran.material.create', compact('material','no'));
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
            $PoMaterial=new MaterialOut();
            $PoMaterial->code=$request->code;
            $PoMaterial->date=$request->date;
            $PoMaterial->material_id=$request->material_id;
            $PoMaterial->quantity=$request->quantity;
            $PoMaterial->keterangan=$request->keterangan;
            $PoMaterial->save();

            $stock=Stock::where('material_id',$request->material_id)->get();
            foreach($stock as $d){
                if($d->quantity < $request->quantity){
                    return redirect()->back()->withErrors('Quantity Kurang');
                } 
                $qty=$d->quantity-$request->quantity;
                Stock::whereId($d->id)
                    ->update([
                        'quantity' => $qty,
                    ]);
            }
            return redirect()->route('pengeluaran_material.index')->with('success', 'Successfully Pengeluaran Material Added.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_material.index')
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
        $matout = MaterialOut::findOrFail($id);
        $material = Material::all();
        return view('produksi.pengeluaran.material.create', compact('matout','material'));
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
            'code' => 'required',
            'material_id' => 'required',
        ]);

        try {
            MaterialOut::whereId($id)
                ->update([
                    'code' => $request->code,
                    'date' => $request->date,
                    'material_id' => $request->material_id,
                    'quantity' => $request->quantity,
                    'keterangan' => $request->keterangan,
                
                ]);
            return redirect()->route('pengeluaran_material.index')->with('success', 'Successfully Updateed.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_material.index')
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
        
        try {
            MaterialOut::whereId($id)->delete();
            return redirect()->route('pengeluaran_material.index')->with('success', 'Successfully Deleted.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_material.index')
                ->with('error', 'Data is not found.');
          }   
    }
}
