<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SamplePackagingOut;
use App\Samplesample_packagings;
use App\SamplePackagings;

class SamplePackagingOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packout = DB::table('pengeluaran_sample_packaging')
        ->select('pengeluaran_sample_packaging.*','sample_packagings.*')
        ->join('sample_packagings','pengeluaran_sample_packaging.sample_packaging_id','sample_packagings.id')
        ->selectRaw('pengeluaran_sample_packaging.id as xx')
        ->orderBy('pengeluaran_sample_packaging.id', 'desc')
        ->get();
        $no = 1;
        return view('produksi.pengeluaran.sample_packaging.index', compact('packout','no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packaging = DB::table('sample_packagings')->get();
        return view('produksi.pengeluaran.sample_packaging.create', compact('packaging'));
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
            $stock= DB::table('sample_packaging_stocks')
                ->where('sample_packaging_stocks.sample_packaging_id',$request->sample_packaging_id)
                ->selectRaw('sum(quantity) as qty')
                ->get();
            $stock_sum = floor($stock[0]->qty);
            if($stock_sum < $request->quantity){
                return redirect()->back()->with('error','Quantity Kurang');
            }
            DB::table('pengeluaran_sample_packaging')
                ->insert([
                    'code' => $request->code,
                    'date' => $request->date,
                    'sample_packaging_id' => $request->sample_packaging_id,
                    'quantity' => $request->quantity,
                    'keterangan' => $request->keterangan,
                ]);
            foreach($stock as $d){
                $qty=$d->qty - $request->quantity;
                DB::table('sample_packaging_stocks')->where('sample_packaging_id',$request->sample_packaging_id)
                    ->update([
                        'quantity' => $qty,
                    ]);
            }
            return redirect()->route('pengeluaran_sample_pck.index')->with('success', 'Successfully Pengeluaran Sample Packaging Added.');
  
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_sample_pck.index')
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
            $packout = SamplePackagingOut::findOrFail($id);
            $packaging = SamplePackagings::all();
            return view('produksi.pengeluaran.sample_packaging.create', compact('packout','packaging'));
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
        return redirect()
            ->route('pengeluaran_sample_pck.index')
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
            $packout = DB::table('pengeluaran_sample_packaging')->where('id',$id)->first();
            
            $stock= DB::table('sample_packaging_stocks')
                ->where('sample_packaging_stocks.sample_packaging_id',$packout->sample_packaging_id)
                ->selectRaw('sum(quantity) as qty')
                ->get();
            $stock_awal = $stock[0]->qty+$packout->quantity;
            if($packout->sample_packaging_id == $request->sample_packaging_id){
                if($stock_awal < intval($request->quantity)){
                    return redirect()->back()->with('error','Production Quantity Kurang');
                }
            }else{
                $stock2= DB::table('sample_packaging_stocks')
                ->where('sample_packaging_stocks.sample_packaging_id',$request->sample_packaging_id)
                ->selectRaw('sum(quantity) as qty')
                ->get();
                if($stock2[0]->qty < $request->quantity){
                    return redirect()->back()->with('error','Production Quantity Kurang');
                }
            }
            DB::table('sample_packaging_stocks')->where('sample_packaging_id',$packout->sample_packaging_id)
                ->update([
                    'quantity' => $stock_awal,
                ]);
            $stock= DB::table('sample_packaging_stocks')
                ->where('sample_packaging_stocks.sample_packaging_id',$request->sample_packaging_id)
                ->selectRaw('sum(quantity) as qty')
                ->get();
            $qty=$stock[0]->qty-$request->quantity;
            DB::table('sample_packaging_stocks')->where('sample_packaging_id',$request->sample_packaging_id)
                ->update([
                    'quantity' => $qty,
                ]);
            DB::table('pengeluaran_sample_packaging')->where('id',$id)
            ->update([
                'code' => $packout->code,
                'date' => $request->date,
                'sample_packaging_id' => $request->sample_packaging_id,
                'quantity' => $request->quantity,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->route('pengeluaran_sample_pck.index')->with('success', 'Successfully Updateed.');
  
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
        return redirect()
            ->route('pengeluaran_sample_pck.index')
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
