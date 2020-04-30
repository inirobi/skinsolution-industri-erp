<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SamplePurchase;
use App\SampleMaterial;
use App\SampleStock;
class SamplePurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase = SamplePurchase::orderBy('id', 'desc')->get();
        $sampleMaterial = SampleMaterial::orderBy('id', 'desc')->get();
        $no = 1;
        return view('inventory.penerimaan.sample.index', compact('purchase', 'no','sampleMaterial'));
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
        $cek = DB::table('sample_purchases')
        ->where('purchase_num',$request->purchase_num)
        ->count();
        
        if($cek > 0){
            return redirect()
                ->route('income_samples.index')
               ->with('error','Code Already Exists!!');
        }
        $date = explode('/',$request->date);
        $date = $date[2]."-".$date[0]."-".$date[1];
        $purchase = SamplePurchase::create([
            'date' => $date,
            'purchase_num' => $request->purchase_num,
            'sample_material_id' => $request->sample_material_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        $stock = SampleStock::where('sample_material_id', $request->input('sample_material_id'))->first();        
            if (!empty($stock)) {
                SampleStock::where('sample_material_id', $request->input('sample_material_id'))
                ->update([
                    'sample_material_id' => $request->input('sample_material_id'),
                    'quantity' => $stock->quantity + $request->input('quantity'),
                ]);

            }else{
                $sup = SampleStock::create([
                    'sample_material_id' => $request->sample_material_id,
                    'quantity' => $request->quantity,
                ]);                        
            }
            
        $material = SampleMaterial::findOrFail($request->sample_material_id);
        $price = $request->price / 1000;
        if($material->price < $price){
            SampleMaterial::whereId($request->sample_material_id)
            ->update([
                'price' => $price,
            ]);        

        }
                
        return redirect()
            ->route('income_samples.index')
            ->with('success','Successfully Sample Income Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
}
