<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductStock;
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

    public function indexStock()
    {
        $stocks = ProductStock::all();
        $no = 1;
        return view('produksi.product.stock', compact('stocks', 'no'));
    }
}
