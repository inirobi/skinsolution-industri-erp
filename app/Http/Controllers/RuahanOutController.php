<?php

namespace App\Http\Controllers;
use App\Gaji;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class RuahanOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packout = DB::table('pengeluaran_ruahan')
        ->select('pengeluaran_ruahan.*','products.*')
        ->join('products','pengeluaran_ruahan.product_id','products.id')
        ->selectRaw('pengeluaran_ruahan.id as xx')
        ->orderBy('pengeluaran_ruahan.updated_at', 'desc')
        ->get();
        $no=1;
      
        return view('produksi.pengeluaran.ruahan.index', compact('packout','no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = DB::table('products')->get();
        return view('produksi.pengeluaran.ruahan.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            if (!isset($request->keterangan)) {
                $request->keterangan = '';
            }
            $stock= DB::table('product_stocks')
            ->select(DB::raw('sum(production_quantity) as qty_product'))
            ->where('product_stocks.product_id',$request->product_id)
            ->get();
            $stock_sum = floor($stock[0]->qty_product);
            if($stock_sum < $request->quantity){
                return redirect()->back()->with('error','Production Quantity Kurang');
            }
            DB::table('pengeluaran_ruahan')
            ->insert([
                'code' => $request->code,
                'date' => $request->date,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'keterangan' => $request->keterangan,
            ]);
            foreach($stock as $d){
                $qty=$stock_sum-$request->quantity;
                DB::table('product_stocks')->where('product_id',$request->product_id)
                    ->update([
                        'production_quantity' => $qty,
                    ]);
            }
        
        return redirect()->route('pengeluaran_ruahan.index')->with('success', 'Successfully Pengeluaran Ruahan Added.');
  
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
        return redirect()
            ->route('pengeluaran_ruahan.index')
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
        $matout = DB::table('pengeluaran_ruahan')->where('id',$id)->first();
        $product = DB::table('products')->get();
        return view('produksi.pengeluaran.ruahan.create', compact('matout','product'));
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
        try {
            $matout = DB::table('pengeluaran_ruahan')->where('id',$id)->first();
            
            $stock= DB::table('product_stocks')
            ->select(DB::raw('sum(production_quantity) as qty_product'))
            ->where('product_stocks.product_id',$matout->product_id)
            ->get();

            $stock_awal = $stock[0]->qty_product+$matout->quantity;
            DB::table('product_stocks')->where('product_id',$matout->product_id)
                    ->update([
                        'production_quantity' => $stock_awal,
                    ]);
                    
            $stock2= DB::table('product_stocks')
                ->select(DB::raw('sum(production_quantity) as qty_product'))
                ->where('product_stocks.product_id',$request->product_id)
                ->get();

            $stock_sum = floor($stock2[0]->qty_product);
            if($stock_sum < $request->quantity){
                return redirect()->back()->with('error','Production Quantity Kurang');
            }

            foreach($stock2 as $d){
                $qty=$stock_sum-$request->quantity;
                DB::table('product_stocks')->where('product_id',$request->product_id)
                    ->update([
                        'production_quantity' => $qty,
                    ]);
            }
            DB::table('pengeluaran_ruahan')->where('id',$id)
            ->update([
                'code' => $matout->code,
                'date' => $request->date,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->route('pengeluaran_ruahan.index')->with('success', 'Successfully Updateed.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_ruahan.index')
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
        //
    }
}
