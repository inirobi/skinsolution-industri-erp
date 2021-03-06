<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LabellingOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no = 1;
        $matout = DB::table('pengeluaran_labelling')
            ->select('pengeluaran_labelling.*','packagings.*')
            ->join('packagings','pengeluaran_labelling.labelling_id','packagings.id')
            ->selectRaw('pengeluaran_labelling.id as xx')
            ->orderBy('pengeluaran_labelling.id', 'desc')
            ->get();
        return view('produksi.pengeluaran.labelling.index', compact('matout','no'));
    }
    
    public function index2()
    {
        $no = 1;
        $matout = DB::table('pengeluaran_labelling2')
        ->select('pengeluaran_labelling2.*','products.*')
        ->join('products','pengeluaran_labelling2.product_id','products.id')
        ->selectRaw('pengeluaran_labelling2.id as xx')
        ->orderBy('pengeluaran_labelling2.id', 'desc')
        ->get();
        $sts='labelling status';
        return view('produksi.pengeluaran.labelling.index', compact('matout','no','sts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packaging = DB::table('packagings')->get();
        return view('produksi.pengeluaran.labelling.create', compact('packaging'));
    }
    public function create2()
    {
        $sts='labelling status';
        $product = DB::table('products')->get();
        return view('produksi.pengeluaran.labelling.create', compact('product','sts'));
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
            if (!isset($request->keterangan)) {
                $request->keterangan = '';
            }
            $stock= DB::table('packaging_stocks')
                ->where('packaging_stocks.packaging_id',$request->labelling_id)
                ->selectRaw('sum(quantity) as qty')
                ->get();
            $stock_sum = floor($stock[0]->qty);
            if($stock_sum < $request->quantity){
                return redirect()->back()->with('error','Quantity Kurang');
            }
            DB::table('pengeluaran_labelling')
                ->insert([
                    'code' => $request->code,
                    'date' => $request->date,
                    'labelling_id' => $request->labelling_id,
                    'quantity' => $request->quantity,
                    'keterangan' => $request->keterangan,
                ]);
            foreach($stock as $d){
                $qty=$d->qty - $request->quantity;
                DB::table('packaging_stocks')->where('packaging_id',$request->labelling_id)
                    ->update([
                        'quantity' => $qty,
                    ]);
            }
            return redirect()->route('pengeluaran_labelling.index')->with('success', 'Successfully Pengeluaran Material Added.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_labelling.index')
                ->with('error', 'Data is not found.');
          }
    }
    public function store2(Request $request)
    {
        try {
            if (!isset($request->keterangan)) {
                $request->keterangan = '';
            }
            $stock= DB::table('product_stocks')
                ->where('product_stocks.product_id',$request->labelling_id)
                ->selectRaw('sum(labelling_quantity) as qty')
                ->get();
            $stock_sum = floor($stock[0]->qty);
            if($stock_sum < $request->quantity){
                return redirect()->back()->with('error','Quantity Kurang');
            }
            DB::table('pengeluaran_labelling2')
                ->insert([
                    'code' => $request->code,
                    'date' => $request->date,
                    'product_id' => $request->labelling_id,
                    'quantity' => $request->quantity,
                    'keterangan' => $request->keterangan,
                ]);
            foreach($stock as $d){
                $qty=$d->qty - $request->quantity;
                DB::table('product_stocks')->where('product_id',$request->labelling_id)
                    ->update([
                        'labelling_quantity' => $qty,
                    ]);
            }
            return redirect()->route('pengeluaran_labelling2.index2')->with('success', 'Successfully Pengeluaran Material Added.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_labelling2.index2')
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
        $matout = DB::table('pengeluaran_labelling')->where('id',$id)->first();
        $packaging = DB::table('packagings')->get();
        return view('produksi.pengeluaran.labelling.create', compact('matout','packaging'));
    }

    public function edit2($id)
    {
        $matout = DB::table('pengeluaran_labelling2')->where('id',$id)->first();
        $sts='labelling status';
        $product = DB::table('products')->get();
        return view('produksi.pengeluaran.labelling.create', compact('matout','product','sts'));
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
            $matout = DB::table('pengeluaran_labelling')->where('id',$id)->first();
            
            $stock= DB::table('packaging_stocks')
                ->select(DB::raw('sum(quantity) as qty_product'))
                ->where('packaging_stocks.packaging_id',$matout->labelling_id)
                ->get();

            $stock_awal = $stock[0]->qty_product+$matout->quantity;
            DB::table('packaging_stocks')->where('packaging_id',$matout->labelling_id)
                ->update([
                    'quantity' => $stock_awal,
                ]);
            $stock2= DB::table('packaging_stocks')
                ->select(DB::raw('sum(quantity) as qty_product'))
                ->where('packaging_stocks.packaging_id',$request->labelling_id)
                ->get();
                $stock_sum = floor($stock2[0]->qty_product);
                if($stock_sum < $request->quantity){
                    return redirect()->back()->with('error','Production Quantity Kurang');
                }
            foreach($stock2 as $d){
                $qty=$stock_sum-$request->quantity;
                DB::table('packaging_stocks')->where('packaging_id',$request->labelling_id)
                    ->update([
                        'quantity' => $qty,
                    ]);
            }
            DB::table('pengeluaran_labelling')->where('id',$id)
            ->update([
                'code' => $matout->code,
                'date' => $request->date,
                'labelling_id' => $request->labelling_id,
                'quantity' => $request->quantity,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('pengeluaran_labelling.index')->with('success', 'Successfully Updateed.');
  
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
        return redirect()
            ->route('pengeluaran_labelling.index')
            ->with('error', 'Data is not found.');
        }
    }
    public function update2(Request $request, $id)
    {
        try {
            $matout = DB::table('pengeluaran_labelling2')->where('id',$id)->first();
            
            $stock= DB::table('product_stocks')
                ->select(DB::raw('sum(labelling_quantity) as qty_product'))
                ->where('product_stocks.product_id',$matout->product_id)
                ->get();

            $stock_awal = $stock[0]->qty_product+$matout->quantity;
            DB::table('product_stocks')->where('product_id',$matout->product_id)
                ->update([
                    'labelling_quantity' => $stock_awal,
                ]);
            $stock2= DB::table('product_stocks')
                ->select(DB::raw('sum(labelling_quantity) as qty_product'))
                ->where('product_stocks.product_id',$request->labelling_id)
                ->get();
                $stock_sum = floor($stock2[0]->qty_product);
                if($stock_sum < $request->quantity){
                    return redirect()->back()->with('error','Production Quantity Kurang');
                }
            foreach($stock2 as $d){
                $qty=$stock_sum-$request->quantity;
                DB::table('product_stocks')->where('product_id',$request->labelling_id)
                    ->update([
                        'labelling_quantity' => $qty,
                    ]);
            }

            DB::table('pengeluaran_labelling2')->where('id',$id)
            ->update([
                'code' => $matout->code,
                'date' => $request->date,
                'product_id' => $request->labelling_id,
                'quantity' => $request->quantity,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('pengeluaran_labelling2.index2')->with('success', 'Successfully Updateed.');
  
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
        return redirect()
            ->route('pengeluaran_labelling2.index2')
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
