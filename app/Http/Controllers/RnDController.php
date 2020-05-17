<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rnd;
use App\Material;

class RnDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no = 1;
        $matout = RnD::orderBy('updated_at', 'desc')->get();
        return view('produksi.distribusi.index', compact('matout','no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $material = Material::all();
        return view('produksi.distribusi.create', compact('material'));
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
            $stock= DB::table('stocks')
                ->select(DB::raw('sum(quantity) as qty'))
                ->where('stocks.material_id',$request->material_id)
                ->get();
            $stock_sum = floor($stock[0]->qty);
            if($stock_sum < $request->quantity){
                return redirect()->back()->with('error','Material Quantity Kurang');
            }
            DB::table('rnd')
            ->insert([ 
                'code' => $request->code,
                'date' => $request->date,
                'material_id' => $request->material_id,
                'quantity' => $request->quantity,
                'keterangan' => $request->keterangan,
            ]);
            foreach($stock as $d){
                $qty=$d->qty-$request->quantity;
                DB::table('stocks')->where('material_id',$request->material_id)
                    ->update([
                        'quantity' => $qty,
                    ]);
            }
            return redirect()->route('rnd.index')->with('success', 'Successfully Pengeluaran Material Added.');
  
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('rnd.index')
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
        $matout = RnD::findOrFail($id);
        $material = Material::all();
        return view('produksi.distribusi.create', compact('matout','material'));
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
            $matout = DB::table('rnd')->where('id',$id)->first();
            
            $stock= DB::table('stocks')
                ->select(DB::raw('sum(quantity) as qty_product'))
                ->where('stocks.material_id',$matout->material_id)
                ->get();

            $stock_awal = $stock[0]->qty_product+$matout->quantity;
            DB::table('stocks')->where('material_id',$matout->material_id)
                ->update([
                    'quantity' => $stock_awal,
                ]);
            $stock2= DB::table('stocks')
                ->select(DB::raw('sum(quantity) as qty_product'))
                ->where('stocks.material_id',$request->material_id)
                ->get();
                $stock_sum = floor($stock2[0]->qty_product);
                if($stock_sum < $request->quantity){
                    return redirect()->back()->with('error','Production Quantity Kurang');
                }
            foreach($stock2 as $d){
                $qty=$stock_sum-$request->quantity;
                DB::table('stocks')->where('material_id',$request->material_id)
                    ->update([
                        'quantity' => $qty,
                    ]);
            }

            DB::table('rnd')->where('id',$id)
            ->update([
                'code' => $matout->code,
                'date' => $request->date,
                'material_id' => $request->material_id,
                'quantity' => $request->quantity,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('rnd.index')->with('success', 'Successfully Updateed.');
  
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('rnd.index')
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
