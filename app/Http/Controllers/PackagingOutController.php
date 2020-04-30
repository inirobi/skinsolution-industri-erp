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
        ->select('pengeluaran_packaging2.*','packagings.*')
        ->join('packagings','pengeluaran_packaging2.product_id','packagings.id')
        ->selectRaw('pengeluaran_packaging2.id as xx')
        ->orderBy('pengeluaran_packaging2.id', 'desc')
        ->get();
        $no = 1;
        $sts='hasil packaging';
        return view('produksi.pengeluaran.packaging.index', compact('packout','no','sts'));
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
        $sts='hasil packaging';
        $packaging = DB::table('packagings')->get();
        return view('produksi.pengeluaran.packaging.create', compact('packaging','sts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request)
    {
        $date = explode('/',$request->date);
        $date = $date[2]."-".$date[0]."-".$date[1];
        try {
            $stock= DB::table('packaging_stocks')
                ->where('packaging_stocks.packaging_id',$request->packaging_id)
                ->selectRaw('sum(quantity) as qty')
                ->get();
            $stock_sum = floor($stock[0]->qty);
            if($stock_sum < $request->quantity){
                return redirect()->back()->with('error','Quantity Kurang');
            }
            DB::table('pengeluaran_packaging2')
                ->insert([
                    'code' => $request->code,
                    'date' => $date,
                    'product_id' => $request->packaging_id,
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
            return redirect()->route('pengeluaran_packaging2.index2')->with('success', 'Successfully Pengeluaran Material Added.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_packaging2.index2')
                ->with('error', 'Data is not found.');
          }
    }
    public function store(Request $request)
    {
        $date = explode('/',$request->date);
        $date = $date[2]."-".$date[0]."-".$date[1];
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
                    'date' => $date,
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
            $dateOut = explode('-',$packout->date);
            $dateOut = $dateOut[1]."-".$dateOut[2]."-".$dateOut[0];
            return view('produksi.pengeluaran.packaging.create', compact('packout','packaging','dateOut'));
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
            $packaging = Packagings::all();
            $dateOut = explode('-',$packout->date);
            $dateOut = $dateOut[1]."-".$dateOut[2]."-".$dateOut[0];
            $sts='hasil packaging';
            return view('produksi.pengeluaran.packaging.create', compact('packout','packaging','dateOut','sts'));
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
            DB::table('packaging_stocks')->where('packaging_id',$packout->packaging_id)
                    ->update([
                        'quantity' => $stock_awal,
                    ]);
            $stock2= DB::table('packaging_stocks')
                ->where('packaging_stocks.packaging_id',$request->packaging_id)
                ->selectRaw('sum(quantity) as qty_p')
                ->get();

            $stock_sum = floor($stock2[0]->qty_p);
            if($stock_sum < $request->quantity){
                return redirect()->back()->with('error','Production Quantity Kurang');
            }

            foreach($stock2 as $d){
                $qty=$stock_sum-$request->quantity;
                DB::table('packaging_stocks')->where('packaging_id',$request->packaging_id)
                    ->update([
                        'quantity' => $qty,
                    ]);
            }

            $date = explode('/',$request->date);
            $date = $date[2]."-".$date[0]."-".$date[1];
            DB::table('pengeluaran_packaging')->where('id',$id)
            ->update([
                'code' => $packout->code,
                'date' => $date,
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
    public function update2(Request $request, $id)
    {
        try {
            $packout = DB::table('pengeluaran_packaging2')->where('id',$id)->first();
            $stock= DB::table('packaging_stocks')
                ->where('packaging_stocks.packaging_id',$packout->product_id)
                ->selectRaw('sum(quantity) as qty')
                ->get();

            $stock_awal = $stock[0]->qty+$packout->quantity;
            DB::table('packaging_stocks')->where('packaging_id',$packout->product_id)
                    ->update([
                        'quantity' => $stock_awal,
                    ]);
            $stock2= DB::table('packaging_stocks')
                ->where('packaging_stocks.packaging_id',$request->packaging_id)
                ->selectRaw('sum(quantity) as qty_p')
                ->get();

            $stock_sum = floor($stock2[0]->qty_p);
            if($stock_sum < $request->quantity){
                return redirect()->back()->with('error','Production Quantity Kurang');
            }

            foreach($stock2 as $d){
                $qty=$stock_sum-$request->quantity;
                DB::table('packaging_stocks')->where('packaging_id',$request->packaging_id)
                    ->update([
                        'quantity' => $qty,
                    ]);
            }

            $date = explode('/',$request->date);
            $date = $date[2]."-".$date[0]."-".$date[1];
            DB::table('pengeluaran_packaging2')->where('id',$id)
            ->update([
                'code' => $packout->code,
                'date' => $date,
                'product_id' => $request->packaging_id,
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
