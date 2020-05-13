<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PackagingOut;
use App\Packagings;

class PackagingOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packout = DB::table('pengeluaran_packaging')
        ->select('pengeluaran_packaging.*','packagings.*')
        ->join('packagings','pengeluaran_packaging.packaging_id','packagings.id')
        ->selectRaw('pengeluaran_packaging.id as xx')
        ->orderBy('pengeluaran_packaging.id', 'desc')
        ->get();
        $no = 1;
        return view('produksi.pengeluaran.packaging.index', compact('packout','no'));
    }

    public function index2()
    {
        $packout = DB::table('pengeluaran_packaging2')
        ->select('pengeluaran_packaging2.*','products.*')
        ->join('products','pengeluaran_packaging2.product_id','products.id')
        ->selectRaw('pengeluaran_packaging2.id as xx')
        ->orderBy('pengeluaran_packaging2.id', 'desc')
        ->get();
        $no = 1;
        return view('produksi.pengeluaran.packaging.index2', compact('packout','no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packaging = DB::table('packagings')->get();
        return view('produksi.pengeluaran.packaging.create', compact('packaging'));
    }

    public function create2()
    {
        $product = DB::table('products')->get();
        return view('produksi.pengeluaran.packaging.create2', compact('product'));
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
            $stock= DB::table('packaging_stocks')
                ->where('packaging_stocks.packaging_id',$request->packaging_id)
                ->selectRaw('sum(quantity) as qty')
                ->get();
            $stock_sum = floor($stock[0]->qty);
            if($stock_sum < $request->quantity){
                return redirect()->back()->with('error','Quantity Kurang');
            }
            DB::table('pengeluaran_packaging')
                ->insert([
                    'code' => $request->code,
                    'date' => $request->date,
                    'packaging_id' => $request->packaging_id,
                    'quantity' => $request->quantity,
                    'keterangan' => $request->keterangan,
                ]);
            foreach($stock as $d){
                $qty=$d->qty - $request->quantity;
                DB::table('packaging_stocks')->where('packaging_id',$request->packaging_id)
                    ->update([
                        'quantity' => $qty,
                    ]);
            }
            return redirect()->route('pengeluaran_packaging.index')->with('success', 'Successfully Pengeluaran Material Added.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_packaging.index')
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
        try{
            $packout = PackagingOut::findOrFail($id);
            $packaging = Packagings::all();
            return view('produksi.pengeluaran.packaging.create', compact('packout','packaging'));
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
        return redirect()
            ->route('pengeluaran_packaging.index')
            ->with('error', 'Data is not found.');
        }
    }
    public function edit2($id)
    {
        try{
            $packout = DB::table('pengeluaran_packaging2')->where('id',$id)->first();
            $product = DB::table('products')->get();
            return view('produksi.pengeluaran.packaging.create2', compact('packout','product'));
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
        return redirect()
            ->route('pengeluaran_packaging2.index2')
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
        try {
            $packout = DB::table('pengeluaran_packaging')->where('id',$id)->first();
            
            $stock= DB::table('packaging_stocks')
                ->where('packaging_stocks.packaging_id',$packout->packaging_id)
                ->selectRaw('sum(quantity) as qty')
                ->get();
            $stock_awal = $stock[0]->qty+$packout->quantity;
            if($packout->packaging_id == $request->packaging_id){
                if($stock_awal < intval($request->quantity)){
                    return redirect()->back()->with('error','Production Quantity Kurang');
                }
            }else{
                $stock2= DB::table('packaging_stocks')
                ->where('packaging_stocks.packaging_id',$request->packaging_id)
                ->selectRaw('sum(quantity) as qty')
                ->get();
                if($stock2[0]->qty < $request->quantity){
                    return redirect()->back()->with('error','Production Quantity Kurang');
                }
            }
            DB::table('packaging_stocks')->where('packaging_id',$packout->packaging_id)
                ->update([
                    'quantity' => $stock_awal,
                ]);
            $stock= DB::table('packaging_stocks')
                ->where('packaging_stocks.packaging_id',$request->packaging_id)
                ->selectRaw('sum(quantity) as qty')
                ->get();
            $qty=$stock[0]->qty-$request->quantity;
            DB::table('packaging_stocks')->where('packaging_id',$request->packaging_id)
                ->update([
                    'quantity' => $qty,
                ]);
            DB::table('pengeluaran_packaging')->where('id',$id)
            ->update([
                'code' => $packout->code,
                'date' => $request->date,
                'packaging_id' => $request->packaging_id,
                'quantity' => $request->quantity,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->route('pengeluaran_packaging.index')->with('success', 'Successfully Updateed.');
  
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
        return redirect()
            ->route('pengeluaran_ruahan.index')
            ->with('error', 'Data is not found.');
        }
    }

    public function store2(Request $request)
    {
        try {
            $stock= DB::table('product_stocks')
                ->where('product_stocks.product_id',$request->product_id)
                ->selectRaw('sum(packaging_quantity) as qty')
                ->get();
            $stock_sum = floor($stock[0]->qty);
            if($stock_sum < $request->quantity){
                return redirect()->back()->with('error','Quantity Kurang');
            }

            if (!isset($request->keterangan)) {
                $request->keterangan='';
            }
            DB::table('pengeluaran_packaging2')
                ->insert([
                    'code' => $request->code,
                    'date' => $request->date,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'keterangan' => $request->keterangan,
                ]);
            foreach($stock as $d){
                $qty=$d->qty - $request->quantity;
                DB::table('product_stocks')->where('product_id',$request->product_id)
                    ->update([
                        'packaging_quantity' => $qty,
                    ]);
            }
            return redirect()->route('pengeluaran_packaging2.index2')->with('success', 'Successfully Pengeluaran Material Added.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_packaging2.index2')
                ->with('error', 'Data is not found.');
          }
    }

    public function update2(Request $request, $id)
    {
        try {

            $packout = DB::table('pengeluaran_packaging2')->where('id',$id)->first();
            $stock= DB::table('product_stocks')
                ->where('product_stocks.product_id',$packout->product_id)
                ->selectRaw('sum(packaging_quantity) as qty')
                ->get();
            
            $stock_awal = $stock[0]->qty+$packout->quantity;
            if($packout->product_id == $request->product_id){
                if($stock_awal < $request->quantity){
                    return redirect()->back()->with('error','Production Quantity Kurang');
                }
            }else{
                $stock2= DB::table('product_stocks')
                    ->where('product_stocks.product_id',$request->product_id)
                    ->selectRaw('sum(packaging_quantity) as qty')
                    ->get();
                if($stock2[0]->qty < $request->quantity){
                    return redirect()->back()->with('error','Production Quantity Kurang');
                }
            }
            DB::table('product_stocks')->where('product_id',$packout->product_id)
                ->update([
                    'packaging_quantity' => $stock_awal,
                ]);
            $stock= DB::table('product_stocks')
                ->where('product_stocks.product_id',$request->product_id)
                ->selectRaw('sum(packaging_quantity) as qty')
                ->get();
            $qty=$stock[0]->qty-$request->quantity;
            DB::table('product_stocks')->where('product_id',$request->product_id)
                ->update([
                    'packaging_quantity' => $qty,
                ]);
            DB::table('pengeluaran_packaging2')->where('id',$id)
            ->update([
                'code' => $packout->code,
                'date' => $request->date,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->route('pengeluaran_packaging2.index2')->with('success', 'Successfully Updateed.');
  
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
