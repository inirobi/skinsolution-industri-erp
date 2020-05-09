<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductStock;
use App\Customer;
use App\Formula;  
use App\TrialRevisionData;
use App\Packaging;
use App\Product;
use App\Labelling;
use App\Material;
use App\SampleMaterial;
use App\FormulaDetail;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = DB::table('products')
            ->select('products.*','customers.*','formulas.*','trial_revision_datas.*')
            ->join('customers','products.customer_id','customers.id')
            ->join('formulas','products.formula_id','formulas.id')
            ->join('trial_revision_datas','products.trial_revision_data_id','trial_revision_datas.id')
            ->selectRaw('products.id as xx')
            ->orderBy('products.updated_at', 'desc')
            ->get();
        $no = 1;
        return view('produksi.product.index', compact('product','no'));
    }
    public function print($id)
    {
        #MASUK
        $product =  Product::find($id);
       $purchasedet=DB::table('products')
       ->join('packaging_activities','packaging_activities.product_id','=','products.id')
       ->join('labellings','labellings.packaging_activity_id','=','packaging_activities.id')
       ->where('products.id',$id)
       ->orderby('labellings.date')
       ->get();
       
       $sum2=DB::table('products')
       ->join('packaging_activities','packaging_activities.product_id','=','products.id')
       ->join('labellings','labellings.packaging_activity_id','=','packaging_activities.id')
       ->where('products.id',$id)
       ->orderby('labellings.date')
       ->sum('result');

       $retur=DB::table('retur')
       ->where('fk_kode_produk',$id)
       ->orderby('retur.tanggal_retur')
       ->get();
       $sum1=DB::table('retur')
       ->where('fk_kode_produk',$id)
       ->orderby('retur.tanggal_retur')
       ->sum('quantity_retur');
       
       //KELUAR

       $purchasedet2=DB::table('delivery_orders')
       ->join('delivery_order_details','delivery_orders.id','=','delivery_order_details.delivery_order_id')
       ->where('delivery_order_details.product_id',$id)
       ->orderby('delivery_orders.date')
       ->get();
       
       $sum3=DB::table('delivery_orders')
       ->join('delivery_order_details','delivery_orders.id','=','delivery_order_details.delivery_order_id')
       ->where('delivery_order_details.product_id',$id)
       ->orderby('delivery_orders.date')
       ->sum('quantity');

       $labelling=DB::table('pengeluaran_labelling2')
       ->join('packaging_activities','packaging_activities.product_id','=','pengeluaran_labelling2.product_id')
       ->join('labellings','labellings.packaging_activity_id','=','packaging_activities.id')
       ->where('pengeluaran_labelling2.product_id',$id)
       ->orderby('labellings.date')
       ->get();
       
       $sum4=DB::table('pengeluaran_labelling2')
       ->join('packaging_activities','packaging_activities.product_id','=','pengeluaran_labelling2.product_id')
       ->join('labellings','labellings.packaging_activity_id','=','packaging_activities.id')
       ->where('pengeluaran_labelling2.product_id',$id)
       ->orderby('labellings.date')

       ->sum('quantity');
       
       $masuk = $sum1 + $sum2;
       $keluar = $sum3 + $sum4;
       $sisa = $masuk - $keluar;
       
        return view('produksi.product.print',compact('product','purchasedet','purchasedet2','retur','labelling','masuk','keluar', 'sisa'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = Customer::all();
        $formula = Formula::all();  
        $revision = TrialRevisionData::all();
        $packaging = Packaging::all();
        return view('produksi.product.create', compact('customer','formula','revision','packaging'));
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
            'product_code' => 'required',
            'product_name' => 'required',
            'customer_id' => 'required',
            'formula_id' => 'required',
            'trial_revision_data_id' => 'required',
            'packaging_id' => 'required',
            'labelling_id' => 'required',
        ]);

        try {
            $cek = DB::table('products')
                ->where('product_code',$request->product_code)
                ->count();
                
            if($cek > 0){
                return redirect()
                    ->route('produksi.create')
                    ->with('error','Code Already Exists!!');
            }
            $sup = Product::create([
                'product_code' => $request->product_code,
                'product_name' => $request->product_name,
                'customer_id' => $request->customer_id,
                'formula_id' => $request->formula_id,
                'trial_revision_data_id' => $request->trial_revision_data_id,
                'description' => $request->description,
                'sale_price' => $request->sale_price,
                'id_packaging' => $request->packaging_id,
                'id_labelling' => $request->labelling_id,
            ]);
    
            $stok = ProductStock::create([
                'product_id' => $sup->id,
            ]); 
          return redirect()
              ->route('produksi.index')
              ->with('success', 'Successfully Created.');

        }catch(Exception $e){
          return redirect()
              ->route('produksi.create')
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
        $product = DB::table('products')
                ->select('products.*','customers.*','formulas.*','trial_revision_datas.*')
                ->join('customers','products.customer_id','customers.id')
                ->join('formulas','products.formula_id','formulas.id')
                ->join('trial_revision_datas','products.trial_revision_data_id','trial_revision_datas.id')
                ->selectRaw('products.id as xx')
                ->where('products.id',$id)
                ->get();
        $formula = formula::all();
        $customer = Customer::all();
        $revision = TrialRevisionData::all();
        $packaging = Packaging::all();
        $labelling = Labelling::all();
        return view('produksi.product.detail', compact('product','formula','customer','revision','packaging','labelling'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = DB::table('products')
                ->select('products.*','customers.*','formulas.*','trial_revision_datas.*')
                ->join('customers','products.customer_id','customers.id')
                ->join('formulas','products.formula_id','formulas.id')
                ->join('trial_revision_datas','products.trial_revision_data_id','trial_revision_datas.id')
                ->selectRaw('products.id as xx')
                ->where('products.id',$id)
                ->get();
        $formula = formula::all();
        $customer = Customer::all();
        $revision = TrialRevisionData::all();
        $packaging = Packaging::all();
        $labelling = Labelling::all();
        return view('produksi.product.edit', compact('product','formula','customer','revision','packaging','labelling'));
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
            'product_code' => 'required',
            'product_name' => 'required',
            'customer_id' => 'required',
            'formula_id' => 'required',
            'trial_revision_data_id' => 'required',
            'packaging_id' => 'required',
            'labelling_id' => 'required',
        ]);

        try {
            
            $sup = Product::where('id', $id)
            ->update([
                'product_code' => $request->product_code,
                'product_name' => $request->product_name,
                'customer_id' => $request->customer_id,
                'formula_id' => $request->formula_id,
                'trial_revision_data_id' => $request->trial_revision_data_id,
                'description' => $request->description,
                'sale_price' => $request->sale_price,
                'id_packaging' => $request->packaging_id,
                'id_labelling' => $request->labelling_id,
            ]);
          return redirect()
              ->route('produksi.index')
              ->with('success', 'Successfully Updated.');

        }catch(Exception $e){
          return redirect()
              ->route('produksi.edit',$id)
              ->with('error', $e->toString());
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
            Product::whereId($id)->delete();
            return redirect()
                ->route('produksi.index')
                ->with('success', 'Successfully Deleted.');

        }catch(Exception $e){
             return redirect()
                ->route('produksi.index')
                ->with('error', "Data Not Found");
        }
    }

    public function indexStock()
    {
        $stocks = ProductStock::all();
        $no = 1;
        return view('produksi.product.stock', compact('stocks', 'no'));
    }

    public function formulaPrint($id)
    {
        $formula = Formula::findOrFail($id);
        $material = Material::all();
        $sampleMaterial = SampleMaterial::all();
        $product = Product::where('formula_id', $id)->first();
        $formula_view = FormulaDetail::where('formula_id', $id)->get();
        return view('produksi.product.printFormula', compact('formula', 'material', 'formula_view','sampleMaterial', 'product'));
    }
}
