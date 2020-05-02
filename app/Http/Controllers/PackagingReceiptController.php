<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PackagingReceipt;
use App\PackagingReceiptDetail;
use App\Packaging;
use App\PackagingStock;
use App\PoPackaging;

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
        $packaging = PackagingReceipt::findOrFail($id);
        $packaging_view = PackagingReceiptDetail::where('packaging_receipt_id', $id)->get();
        $pck = Packaging::all();
        return view('inventory.penerimaan.packaging.view', compact('packaging', 'packaging_view','pck'));
    }

    public function storeCS(Request $request)
    {
        PackagingReceiptDetail::create($request->all());
        $stock = PackagingStock::where('packaging_id', $request->input('packaging_id'))->first();        
            if (!empty($stock)) {
                PackagingStock::where('packaging_id', $request->input('packaging_id'))
                ->update([
                    'quantity' => $stock->quantity + $request->input('quantity'),
                ]);
            }

        return redirect()    
            ->route('packaging_receipt.show',$request->input('packaging_receipt_id'))
            ->with('success','Successfully PackagingReceipt Updated');
    }

    public function viewAddSS($id)
    {
        $po = PoPackaging::all();
        return view('inventory.penerimaan.packaging.detail', compact('po', 'id'));
    }

    public function ViewStorAjax(Request $request)
    {
        PackagingReceiptDetail::create($request->all());
        $stock = PackagingStock::where('packaging_id', $request->input('packaging_id'))->first();        
            if (!empty($stock)) {
                PackagingStock::where('packaging_id', $request->input('packaging_id'))
                ->update([
                    'quantity' => $stock->quantity + $request->input('quantity'),
                ]);
            }

        return Response::json("Successfully Add");
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
        if ($request->receipt_code == '' || $request->packaging_type2=='') {
            return redirect()
                ->route('packaging_receipt.index')
                ->with('error','Inputan tidak Valid!!!');
        }

        PackagingReceipt::whereId($id)
            ->update([
                'packaging_type' => $request->packaging_type2,
                'receipt_code' => $request->receipt_code,
            ]);

        return redirect()
            ->route('packaging_receipt.index')
            ->with('success','Successfully PackagingReceipt Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            PackagingReceipt::whereId($id)->delete();
            return redirect()
                ->route('packaging_receipt.index')
                ->with('success', 'Successfully PackagingReceipt Delete.');
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('packaging_receipt.index')
                ->with('error', 'Data Not found!.');
          }
    }
}
