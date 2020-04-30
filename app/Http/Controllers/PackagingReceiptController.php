<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PackagingReceipt;
use Illuminate\Support\Facades\DB;

class PackagingReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packaging = PackagingReceipt::orderBy('id', 'desc')->get();
        $no = 1;
        return view('inventory.penerimaan.packaging.index', compact('packaging','no'));
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
        if ($request->date == '' || $request->packaging_type=='') {
            return redirect()
                ->route('packaging_receipt.index')
                ->with('error','Inputan tidak Valid!!!');
        }

        $cek = DB::table('packaging_receipts')
            ->where('receipt_code',$request->receipt_code)
            ->count();
        
        if($cek > 0){
            return redirect()
                ->route('packaging_receipt.index')
                ->with('error','Code Already Exists!!');
        }
        $date = explode('/',$request->date);
        $date = $date[2]."-".$date[0]."-".$date[1];
        $packaging = PackagingReceipt::create([
            'tanggal_recep' => $date,
            'packaging_type' => $request->packaging_type,
            'receipt_code' => $request->receipt_code,
            'customer_id' => 0,
        ]);

        return redirect()
            ->route('packaging_receipt.index')
            ->with('success','Successfully PackagingReceipt Added');
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
