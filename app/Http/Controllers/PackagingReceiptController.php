<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PackagingReceipt;
use App\PackagingReceiptDetail;
use App\Packaging;
use App\PackagingStock;
use App\PoPackaging;
use App\PoPackagingDetail;
use App\Customer;
use App\Supplier;

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
        $packaging = PackagingReceipt::orderBy('updated_at', 'desc')->get();
        $customers = Customer::all();
        $suppliers = Supplier::all();
        $no = 1;
        return view('inventory.penerimaan.packaging.index', compact('packaging','no','customers','suppliers'));
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
        $packaging = PackagingReceipt::create([
            'tanggal_recep' => $request->date,
            'packaging_type' => $request->packaging_type,
            'receipt_code' => $request->receipt_code,
            'customer_id' => $request->customer,
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
        $packaging_view = PackagingReceiptDetail::where('packaging_receipt_id', $id)
                            ->orderBy('updated_at','desc')
                            ->get();
        $pck = Packaging::groupBy('customer_id')
                ->where('packaging_type','CS')
                ->where('customer_id', $packaging->customer_id)
                ->get();
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

    public function viewAddSS($id, $supplier)
    {
        $po = PoPackaging::where([
            ['supplier_id', '=', $supplier],
            ['status', '<>', "Close"],
        ])->get();

        return view('inventory.penerimaan.packaging.detail', compact('po', 'id'));
    }

    public function ViewStorAjax(Request $request)
    {
        if (!isset($request->quantity)) {
            return redirect()
                ->route('packaging_receipt.showSS',$request->packaging_receipt_id)
                ->with('error', "Invalid input!");
        }
        $count_detail_po = PoPackagingDetail::where([
            ['po_packaging_id', '=', $request->po_packaging_id]
        ])->count();
        if($count_detail_po < 1){
            return redirect()
                ->route('packaging_receipt.showSS',$request->packaging_receipt_id)
                ->with('error', "Po Packaging Detail doesn't have data !");
        }
        $count_accepted_done = 0;
        $panjang = count(collect($request->packaging_id));
        for ($i=0; $i <$panjang ; $i++)
        { 
            if(intval($request->quantity[$i]) > 0)
            {
                $prd = new PackagingReceiptDetail;
                $prd->packaging_receipt_id = $request->packaging_receipt_id;
                $prd->quantity = $request->quantity[$i];
                $prd->packaging_id = $request->packaging_id[$i];
                $stock = PackagingStock::where('packaging_id', $request->packaging_id[$i])->first();        
                if (!empty($stock))
                {
                    PackagingStock::where('packaging_id', $request->packaging_id[$i])
                    ->update([
                        'quantity' => $stock->quantity + $request->quantity[$i],
                    ]);
                    $ppd_ = PoPackagingDetail::where([
                        ['po_packaging_id', '=', $request->po_packaging_id],
                        ['packaging_id', '=', $request->packaging_id[$i]]
                    ])->first();
                    PoPackagingDetail::where([
                        ['po_packaging_id', '=', $request->po_packaging_id],
                        ['packaging_id', '=', $request->packaging_id[$i]]
                    ])->update([
                        'accepted_quantity' => intval($ppd_->accepted_quantity) + intval($request->quantity[$i]),
                    ]);
                    $ppd = PoPackagingDetail::where([
                        ['po_packaging_id', '=', $request->po_packaging_id],
                        ['packaging_id', '=', $request->packaging_id[$i]]
                    ])->first();
                    $quantity = intval($ppd->quantity);
                    $accepted = intval($ppd->accepted_quantity);
                    if($quantity-$accepted < 1)
                    {
                        $count_accepted_done += 1;
                    }
                }
                else
                {
                    return redirect()
                        ->route('packaging_receipt.showSS',$request->packaging_receipt_id)
                        ->with('error', "failed add! Check stock packaging");
                }
                $prd->save();
            }
        }
        if($count_detail_po == $count_accepted_done){
            PoPackaging::where('id', $request->po_packaging_id)
            ->update([
                'status' => "Close",
            ]);
        }
        return redirect()
            ->route('packaging_receipt.show',$request->packaging_receipt_id)
            ->with('success', "Success Added!");
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
        if($request->customer2!=NULL)
        {
            PackagingReceipt::whereId($id)
            ->update([
                'packaging_type' => $request->packaging_type2,
                'receipt_code' => $request->receipt_code,
                'customer_id' => $request->customer2,
                'supplier_id' => 0,
            ]);
        }
        else
        {
            $c = PackagingReceipt::whereId($id)
            ->update([
                'packaging_type' => $request->packaging_type2,
                'receipt_code' => $request->receipt_code,
                'supplier_id' => $request->supplier2,
                'customer_id' => 0,
            ]);
        }

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
