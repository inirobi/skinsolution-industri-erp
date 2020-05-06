<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materials;
use Illuminate\Support\Facades\DB;
use App\MaterialSupplier;
use App\Suppliers;
use App\MaterialKontradiksi;
use App\PoMaterial;
use App\PoMaterialDetail;

use PDF; 

class MaterialsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tamp = Materials::orderBy('updated_at', 'desc')->get();
        return view('inventory.bahan_baku.index',['materials'=> $tamp, 'no'=>1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.bahan_baku.create');
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
            'material_code' => 'required',
            'cas_num' => 'required',
            'material_name' => 'required',
            'inci_name' => 'required',
            'stock_minimum' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        try {
            $req = $request->all();
            Materials::create([
                'id' => null,
                'material_code' => $req['material_code'],
                'cas_num' => $req['cas_num'],
                'material_name' => $req['material_name'],
                'inci_name' => $req['inci_name'],
                'stock_minimum' => $req['stock_minimum'],
                'category' => $req['category'],
                'price' => $req['price'],
              ]);
          return redirect()
              ->route('materials.index')
              ->with('success', 'Data bahan baku berhasil disimpan.');

        }catch(Exception $e){
          return redirect()
              ->route('materials.create')
              ->with('error', $e->toString());
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
        $sup= DB::table('material_suppliers')
        ->select('material_suppliers.*','suppliers.*','materials.*')
        ->join('suppliers','suppliers.id','=','material_suppliers.supplier_id')
        ->join('materials','materials.id','=','material_suppliers.material_id')
        ->selectRaw('material_suppliers.id as id_x')
        ->where('material_suppliers.material_id',$id)->get();

        $supplier= Suppliers::all();
        return view('inventory.bahan_baku.supplier',['sup' => $sup, 'id' => $id, 'supplier' => $supplier]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $materials = Materials::findOrFail($id);
            return view('inventory.bahan_baku.create', ['materials' => $materials]);
  
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
        return redirect()
            ->route('materials.index')
            ->with('error', 'Data is not found.');
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
        $this->validate($request,[
            'material_code' => 'required',
            'cas_num' => 'required',
            'material_name' => 'required',
            'inci_name' => 'required',
            'stock_minimum' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        try {
          $req = $request->all();
          $materials = Materials::findOrFail($id);
          $materials->material_code = $req['material_code'];
          $materials->cas_num = $req['cas_num'];
          $materials->material_name = $req['material_name'];
          $materials->inci_name = $req['inci_name'];
          $materials->stock_minimum = $req['stock_minimum'];
          $materials->category = $req['category'];
          $materials->price = $req['price'];
          $materials->save();

          return redirect()
              ->route('materials.index')
              ->with('success', 'Successfully Updated.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('materials.index')
              ->with('error', 'Data is not found.');
        }
    }

    public function Print($id)
    {
        $purchase = PoMaterial::where('id',$id)->get();
        $purchase_view = PoMaterialDetail::where('po_material_id', $id)->get();
        $pdf = PDF::loadView('inventory.bahan_baku.print',compact('purchase','purchase_view'));
        return $pdf->stream();
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
            $materials = Materials::findOrFail($id)->delete();
  
            return redirect()
                ->route('materials.index')
                ->with('success', 'Successfully Deleted.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('materials.index')
                ->with('error', 'Data is not found.');
          }
    }

    public function dataStock()
    {
        $stocks = DB::table('stocks')
            ->join('materials', 'stocks.material_id', '=', 'materials.id')
            ->select('stocks.*', 'materials.*')
            ->orderBy('materials.updated_at', 'desc')
            ->get();
        return view('inventory.bahan_baku.stocks',['stocks'=> $stocks, 'no'=>1]);
    }

    // suppliers

    public function kontradiksiStore(Request $request)
    {
        $x = DB::table('material_kontradiksi')->where([
                ['material_kontradiksi_id', '=', $request->material_kontradiksi_id],
                ['material_id', '=', $request->material_id],
            ])->count();
        if($x>0){
            return redirect()->back()->with('error', 'Supplier Already Exist');
        }else{
            $sup = MaterialKontradiksi::create([
                'id' => null,
                'material_id' => $request->material_id,
                'material_kontradiksi_id' => $request->material_kontradiksi_id,
            ]);
            return redirect()->back()->with('success', 'Successfully Created.');
        }
        
    }

    public function kontradiksiDelete($id)
    {

        try {
            MaterialKontradiksi::whereId($id)->delete();
            return redirect()->back()->with('success', 'Successfully Deleted.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('materials.index')
                ->with('error', 'Data is not found.');
          }   
    }

    public function kontradiksiShow($id)
    {
        $datas= DB::table('material_kontradiksi')
            ->select('material_kontradiksi.*','materials.material_name','materials.material_code','materials.category')
            ->join('materials','materials.id','=','material_kontradiksi.material_kontradiksi_id')
            ->selectRaw('material_kontradiksi.id as id_x')
            ->where('material_kontradiksi.material_id',$id)->get();

        $material= Materials::whereNotIn('id',[$id])->get();
        return view('inventory.bahan_baku.kontradiksi',['datas' => $datas, 'id' => $id, 'material' => $material]);
    }
}
