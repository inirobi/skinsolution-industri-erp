<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use App\Materials;
use App\MaterialSupplier;
use App\Suppliers;
use App\MaterialKontradiksi;
use App\PoMaterial;
use App\PoMaterialDetail;
use App\Material;
use App\Product;
use App\Stocks;

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
        $sup = DB::table('material_suppliers as a')->select('a.*','b.*')->join('suppliers as b','a.supplier_id','=','b.id')->get();
        $mat =DB::table('materials as a')->selectRaw('a.*, count(b.supplier_id) as count')->Leftjoin('material_suppliers as b','a.id','=','b.material_id')->groupBy('b.material_id')->get();
        $materials = Materials::orderBy('updated_at', 'desc')->get();
        $no = 1;
        return view('inventory.bahan_baku.index',compact('materials', 'no', 'mat', 'sup'));
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
            $id = DB::getPdo()->lastInsertId();
            Stocks::create([
                'id' => null,
                'material_id' => $id,
                'quantity' => 0,
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
        ->where('material_suppliers.material_id',$id)
        ->orderBy('material_suppliers.updated_at','desc')
        ->get();

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
        $material =  Material::find($id);
    
        //MASUK
        
        $purchase =DB::table('purchases as a')
        ->join('purchase_details as b','a.id','=','b.purchase_id')
        ->where('b.material_id',$id)
        ->orderby('b.created_at','asc')
        ->get();
        
        $sum=DB::table('purchases as a')
        ->join('purchase_details as b','a.id','=','b.purchase_id')
        ->where('b.material_id',$id)
        ->orderby('b.created_at')
        ->sum('quantity');
    
        //KELUAR
        
        $formula = DB::table('formulas')
        ->join('formula_details','formula_details.formula_id','=','formulas.id')
        ->join('pengeluaran_material','pengeluaran_material.material_id','=','formula_details.material_id')
        ->join('product_activity_details','product_activity_details.material_id','=','formula_details.material_id')
        ->join('product_activities','product_activities.id','=','product_activity_details.product_activity_id')
        ->where('formula_details.material_id',$id)
        ->orderby('formula_details.created_at','asc')
        ->groupBy('formula_details.id')
        ->get(); 
        
        $pro_act = DB::table('product_activities')
        ->join('product_activity_details','product_activities.id','=','product_activity_details.product_activity_id')
        ->where('product_activity_details.material_id',$id)
        ->orderby('product_activity_details.created_at','asc')
        ->groupBy('product_activity_details.id')
        ->get();
        
        $pro_mat = DB::table('pengeluaran_material')
        ->where('material_id',$id)
        ->orderby('pengeluaran_material.created_at','asc')
        ->groupBy('pengeluaran_material.id')
        ->get();
        
        $sum2 = DB::table('formulas')
        ->join('formula_details','formula_details.formula_id','=','formulas.id')
        ->where('formula_details.material_id',$id)
        ->sum('weighing');
        
        $sum3 = DB::table('product_activities')
        ->join('product_activity_details','product_activities.id','=','product_activity_details.product_activity_id')
        ->where('product_activity_details.material_id',$id)
        ->sum('weighing');
        
        $sum4 = DB::table('pengeluaran_material')
        ->where('material_id',$id)
        ->sum('quantity');
        
        $formula = DB::table('formulas')
            ->join('formula_details','formula_details.formula_id','=','formulas.id')
            ->where('formula_details.material_id',$id)
            ->get();

        $pro_act = DB::table('product_activities')
            ->join('product_activity_details','product_activities.id','=','product_activity_details.product_activity_id')
            ->where('product_activity_details.material_id',$id)
            ->get();
        $pro_mat = DB::table('pengeluaran_material')
            ->where('material_id',$id)
            ->get();

        $cetak_keluar=[];

        foreach ($formula as $data) {
            $field['tanggal'] = $this->convertToCorrectDateValue(substr($data->created_at,0,10));
            $field['keterangan'] = $data->formula_num;
            $field['quantity'] = $data->quantity;
            $cetak_keluar[] = (object)$field;
        }
        foreach ($pro_act as $data) {
            $field['tanggal'] = $this->convertToCorrectDateValue(substr($data->date_start,0,10));
            $field['keterangan'] = $data->activity_code;
            $field['quantity'] = $data->weighing;
            $cetak_keluar[] = (object)$field;
        }
        foreach ($pro_mat as $data) {
            $field['tanggal'] = $this->convertToCorrectDateValue(substr($data->date,0,10));
            $field['keterangan'] = $data->code;
            $field['quantity'] = $data->quantity;
            $cetak_keluar[] = (object)$field;
        }
        $collect = Collection::make($cetak_keluar);
        $datas = $collect->sortBy('tanggal');
        $sisa = $sum - ($sum2 + $sum3 + $sum4);
        $masuk = $sum;
        $keluar = $sum2 + $sum3 + $sum4;
        return view('inventory.bahan_baku.print',compact('masuk','keluar','purchase','formula','pro_act','pro_mat','datas','sisa','material'));
    }

    public function convertToCorrectDateValue($date="05/02/2020")
    {
        $temp = explode("/", $date);
        if(strlen($temp[0]) > 2)
        {
            return $date;
        }
        else
        {
            return $temp[2]."-".$temp[0]."-".$temp[1];
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

    public function SupplierStore(Request $request)
    {
        
        $x = DB::table('material_suppliers')
        ->where([
            ['supplier_id',$request->supplier_id],
            ['material_id',$request->material_id]
        ])->count();
        if($x>0){
            return redirect()->back()->with('error','Supplier Already Exist');
        }
        else{
            $sup = MaterialSupplier::create([
                'material_id' => $request->material_id,
                'supplier_id' => $request->supplier_id,
            ]);
        }

        return redirect()->back()->with('success','Successfully Created');
    }

    public function SupplierDelete($id)
    {
        MaterialSupplier::whereId($id)->delete();
        return redirect()->back()->with('success','Successfully Deleted');
    }

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
