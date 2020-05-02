<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PoCustomer;

class ReturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $retur = DB::table('retur')        
        ->join('po_products','retur.fk_no_po','po_products.id')
        ->join('products','retur.fk_kode_produk','products.id')        
        ->get();
        $no = 1;
        $add = DB::table('po_products')->get();
        $customer = PoCustomer::all();
        return view('produksi.retur.index', compact('retur','no','add','customer'));
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
        
        try {
            $cek = DB::table('po_product_details')
            ->join('products','po_product_details.product_id','products.id')
            ->where('products.id',$request->products)
            ->first();
            

            $jum = DB::table('packaging_stocks')
            ->where('packaging_id',$cek->id_packaging)
            ->where('packaging_id',$cek->id_labelling)
            ->sum('quantity');
            
            $c = DB::table('packaging_stocks')->where('packaging_id',$cek->packaging)->count();
            if($c == 0){
                DB::table('packaging_stocks')->where('packaging_id',$cek->packaging)->insert([
                    'packaging_id' => $cek->packaging,            
                    'quantity' => $request->quantity_pack,
                ]);  
            }
            else{
                
                DB::table('packaging_stocks')->where('packaging_id',$cek->packaging)->update([
                    'quantity' => $jum + $request->quantity_pack,
                ]); 
            }
            
            $max = DB::table('leftover')
            ->where([
                ['po_id',$request->po_customer_ids],
                ['pro_id',$request->products]
            ])->sum('quantity');
            
            
            DB::table('leftover')
            ->where([
                ['po_id',$request->po_customer_ids],
                ['pro_id',$request->products]
            ])->update([
                'quantity' => $max + $request->quantity
            ]);
            
            
            
            DB::table('retur')->insert([
                'tanggal_retur' => $request->date,
                'fk_kode_produk' => $request->products,
                'fk_no_po' => $request->po_customer_ids,            
                'quantity_retur' => $request->quantity,
                'quantity_pack' => $request->quantity_pack,
                'alasan' => $request->reason,

            ]);
            return redirect()
                ->route('retur.index')
                ->with('success', 'Successfully Created.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('retur.index')
                ->with('error', 'Data is not found.');
          }

       return redirect()->back()->withMsg('Successfully Created');
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
}
