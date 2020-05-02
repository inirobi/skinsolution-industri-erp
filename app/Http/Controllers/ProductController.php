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
}
