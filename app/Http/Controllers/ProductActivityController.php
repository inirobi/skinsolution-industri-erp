<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PoProduct;
use App\ProductActivity;
use App\Product;
use App\ProductActivityDetail;
use App\Stock;
use App\PoProductDetail;
use Illuminate\Support\Facades\Response; 
use Illuminate\Support\Facades\Auth; 

class ProductActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no = 1;
        $po = PoProduct::all();
        if(Auth::user()->role == 0){
            $productactivity = DB::table('product_activities')
                ->select('product_activities.*','po_products.po_num')
                ->join('po_products','po_products.id','product_activities.po_product_id')
                ->orderBy('product_activities.updated_at', 'desc')
                ->get();
        }elseif(Auth::user()->role == 8){
            $productactivity = DB::table('product_activities')
                ->select('product_activities.*','po_products.po_num')
                ->join('po_products','po_products.id','product_activities.po_product_id')
                ->orderBy('product_activities.updated_at', 'desc')
                ->where('po_products.customer_id', Auth::user()->email)
                ->get();
        }
        return view('produksi.kegiatan.product.index', compact('no','productactivity','po'));
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
        $cek = DB::table('product_activities')
            ->where('activity_code',$request->activity_code)
            ->count();
        
        if($cek > 0){
            return redirect()
                ->route('activity_product.index')
                ->with('error','Code Already Exists!!');
        }elseif($request->activity_code == '' || $request->activity_code == 'date_start' || $request->activity_code == 'po_product_id'){
            return redirect()
                ->route('activity_product.index')
                ->with('error','Inputan Tidak Valid!!');
        }
        
        ProductActivity::create($request->all());
        return redirect()
            ->route('activity_product.index')
            ->with('success','Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productactivity = ProductActivity::findOrFail($id);
        $product = Product::all();
        $activity_view = ProductActivityDetail::where('product_activity_id', $id)->get();
        return view('produksi.kegiatan.product.view', compact('product', 'activity_view','productactivity','id'));
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
        if($request->activity_code == '' || $request->activity_code == 'date_start' || $request->activity_code == 'po_product_id'){
            return redirect()
                ->route('activity_product.index')
                ->with('error','Inputan Tidak Valid!!');
        }

        $sup = ProductActivity::where('id', $id)
            ->update([
                'activity_code' => $request->activity_code,
                'date_start' => $request->date_start    ,
                'date_end' => $request->date_end,
                'po_product_id' => $request->po_product_id,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()
            ->route('activity_product.index')
            ->with('success','Successfully Updated');
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
            ProductActivity::whereId($id)->delete();
            return redirect()
                ->route('activity_product.index')
                ->with('success', 'Successfully Deleted.');

        }catch(Exception $e){
             return redirect()
                ->route('activity_product.index')
                ->with('error', "Data Not Found");
        }
    }

    public function ViewStoreAjax(Request $request)
    {   
        
        $cek = sizeof($request->all());
        if (!isset($request->result_target) || !isset($request->result_real) || $cek<=5) {
            return redirect()
                ->route('activity_product.view.add',$request->product_activity_id)
                ->with('error', "Invalid input");
        }
        $panjang = count(collect($request->weighing));
        for ($i=0; $i < $panjang; $i++) { 
            $pad = new ProductActivityDetail;
            $pad->product_activity_id = $request->product_activity_id;
            $pad->product_id = $request->product_id;
            $pad->result_target = $request->result_target;
            $pad->result_real = $request->result_real;
            $pad->material_id = $request->material_id[$i];
            $pad->quantity = $request->quantity[$i];
            $pad->weighing = $request->weighing[$i];
            $stock = Stock::where('material_id', $request->material_id[$i])->first();        
            if (!empty($stock) && $stock->quantity >= $request->weighing[$i]) {
                Stock::where('material_id', $request->material_id[$i])
                ->update([
                    'quantity' => $stock->quantity - $request->weighing[$i],
                ]);
            }else{
                return redirect()
                    ->route('activity_product.show',$request->product_activity_id)
                    ->with('error',"failed add! Check stock material");
            }
            $pad->save();
        }
        return redirect()
            ->route('activity_product.show',$request->product_activity_id)
            ->with('success', "Success fully Added");    
    }
    public function ViewAdd($id)
    {
        $productactivity = ProductActivity::findOrFail($id);
        $poProduct = PoProductDetail::where('po_product_id', $productactivity->po_product_id)->get();
        $totalQtyPo = 0;
        foreach($poProduct as $dt){
            $totalQtyPo = $totalQtyPo + ($dt->quantity * $dt->pack);
        }
        $product=DB::table('product_activities')
            ->select('products.id','products.product_name')
            ->join('po_products','product_activities.po_product_id','=','po_products.id')
            ->join('po_product_details','po_product_details.po_product_id','=','po_products.id')
            ->join('products','products.id','=','po_product_details.product_id')
            ->where('product_activities.id',$id)->get();

        $activity_view = ProductActivityDetail::where('product_activity_id', $id)->get();
        return view('produksi.kegiatan.product.detail', compact('product', 'activity_view','productactivity', 'totalQtyPo'));
    }

    public function ViewSub($id, $product_id)
    {
        $productactivity = ProductActivity::findOrFail($id);
        $productCode = ProductActivityDetail::where('product_activity_id', $id)->first();
        // $activity_view = ProductActivityDetail::where('product_activity_id', $id)->get();
        $a=DB::table('product_activity_details')
                ->select('materials.id','materials.material_name',
                            'product_activity_details.quantity','product_activity_details.weighing','product_activity_details.created_at')
                ->join('products','product_activity_details.product_id','=','products.id')
                ->join('formulas','products.formula_id','=','formulas.id')
                ->join('formula_details','formula_details.formula_id','=','formulas.id')
                ->join('materials','product_activity_details.material_id','=','materials.id')
                ->where('product_activity_details.product_activity_id',$id)
                ->where('product_activity_details.product_id',$product_id)
                ->where('formula_details.source_material',1)
                ->groupBy('materials.id','materials.material_name', 'product_activity_details.weighing', 'product_activity_details.quantity','product_activity_details.created_at')
                ->orderBy('product_activity_details.id', 'desc')
                ->get();

        $b=DB::table('product_activity_details')
                ->select('sample_materials.id','sample_materials.material_name',
                            'product_activity_details.quantity','product_activity_details.weighing','product_activity_details.created_at')
                ->join('products','product_activity_details.product_id','=','products.id')
                ->join('formulas','products.formula_id','=','formulas.id')
                ->join('formula_details','formula_details.formula_id','=','formulas.id')
                ->join('sample_materials','product_activity_details.material_id','=','sample_materials.id')
                ->where('product_activity_details.product_activity_id',$id)
                ->where('product_activity_details.product_id',$product_id)
                ->where('formula_details.source_material',0)
                ->groupBy('sample_materials.id','sample_materials.material_name', 'product_activity_details.weighing', 'product_activity_details.quantity','product_activity_details.created_at')
                ->orderBy('product_activity_details.id', 'desc')
                ->get();

        //$subcategories= Supplier::where('id',$categories->supplier_id)->get();
        $activity_view = $a->merge($b);        
        return view('produksi.kegiatan.product.detailView', compact('productCode', 'activity_view','productactivity'));
    }
}
