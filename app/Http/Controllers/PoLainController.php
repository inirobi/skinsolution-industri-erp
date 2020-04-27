<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PoLain;
use App\NotifLain;
use App\PoLainDetail;
use App\Petty;
use App\Supplier;
use Carbon\Carbon;
class PoLainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lain = PoLain::orderBy('id', 'desc')->get();
        return view('accounting.pengeluaran.lain.index', compact('lain'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lain = PoLain::orderBy('id', 'desc')->get();
        $supplier = Supplier::all();

        // var_dump($lain);die;
        return view('accounting.pengeluaran.lain.create',['supplier'=>$supplier]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'po_num' => 'required',
            'supplier_id' => 'required',
            'terms' => 'required',
            'date' => 'required',
            'ppn' => 'required',
        ]);

        try {
            
            $cek = DB::table('po_lain')
            ->where('po_num',$request->po_num)
            ->count();
            
            if($cek > 0){
                return redirect()
                ->route('pengeluaran_lain.create')
                ->with('Code Already Exists!!');
            }
            
            date_default_timezone_set('Asia/Jakarta');   
            if($request->terms == "7 Days"){
                $tempo = date('m/d/Y 23:59', strtotime('+1 friday', strtotime($request->date)));    
            }
            else if($request->terms == "14 Days"){
                $tempo = date('m/d/Y 23:59', strtotime('+2 friday', strtotime($request->date)));    
            }
            else if($request->terms == "30 Days"){
                $tempo = date('m/d/Y 23:59', strtotime('+4 friday', strtotime($request->date)));die;
            }
            else if($request->terms == "Cash"){
                $tempo = "00-00-0000";
            }

            if($request->terms=='Cash'){
                $status='Paid';
                
                $petty=new Petty();
                $petty->date= $request->date;
                $petty->money='0';
                $petty->status='0';
                $petty->saldo='0';
                $petty->keterangan='Pembayaran PO Lain';
                $petty->save();
            }else{
                $status='Unpaid';
            }
            $Polain=new PoLain();
            $Polain->po_num=$request->po_num;
            $Polain->supplier_id=$request->supplier_id;
            $Polain->date=$request->date;
            $Polain->tempo=$tempo;
            $Polain->ppn=$request->ppn;
            $Polain->terms=$request->terms;
            $Polain->status=$status;
            $Polain->save();
          return redirect()
              ->route('pengeluaran_lain.index')
              ->with('success', 'Successfully PurchaseOrder Added.');

        }catch(Exception $e){
          return redirect()
              ->route('pengeluaran_lain.create')
              ->with('error', $e->toString());
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
        $lain = PoLain::findOrFail($id);
        $lain_view = PoLainDetail::where('polain_id', $id)->get();
        return view('accounting.pengeluaran.lain.view', compact('lain','lain_view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lain = PoLain::findOrFail($id);
        $supplier = Supplier::all();
        return view('accounting.pengeluaran.lain.create', compact('lain','supplier'));
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
        $this->validate($request,[
            'po_num' => 'required',
            'supplier_id' => 'required',
            'terms' => 'required',
            'date' => 'required',
            'ppn' => 'required',
        ]);

        try {
            
            PoLain::whereId($id)
            ->update([
                'po_num' => $request->po_num,
                'supplier_id' => $request->supplier_id,
                'status' => $request->status,
            ]);
            if($request->status=='Paid'){
                $popack = PoLain::find($id);
                $poPackagingdetail = PoLainDetail::where('polain_id', $id)->get(); 
                $total = 0;
                $PPN = 0;
                foreach ($poPackagingdetail as $dataDetail) {
                    $total = $total + ($dataDetail->quantity * $dataDetail->price);
                }

                $PPN = 0.10 * $total;
                if($popack->ppn=='1'){
                    $total = $total + $PPN;
                }
                $mytime = Carbon::now();
                $petty=new Petty();
                $petty->date= $mytime->format('m/d/Y h:i A');
                $petty->money=$total;
                $petty->status='0';
                $petty->saldo='0';
                $petty->keterangan='Pembayaran PO Packaging';
                $petty->save();

            }
          return redirect()
              ->route('pengeluaran_lain.index')
              ->with('success', 'Successfully PurchaseOrder Added.');

        }catch(Exception $e){
          return redirect()
              ->route('pengeluaran_lain.create')
              ->with('error', $e->toString());
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
        try {
        PoLain::whereId($id)->delete();
        return redirect()
            ->route('pengeluaran_lain.index')
            ->with('success','Successfully PurchaseOrder Delete');;

        }catch(Exception $e){
          return redirect()
            ->route('pengeluaran_lain.index')
            ->with('error', 'Failed PurchaseOrder Delete');
        }
        
    }

    public function ViewStore(Request $request)
    {  
        $this->validate($request,[
            'nama_barang' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        try {
            $Polain=new PoLainDetail();
            $Polain->polain_id=$request->polain_id;
            $Polain->nama_barang=$request->nama_barang;
            $Polain->quantity=$request->quantity;
            $Polain->price=$request->price;
            $Polain->save();
            return redirect()
                ->route('pengeluaran_lain.show',$request->input('polain_id'))
                ->with('success','Successfully PurchaseOrder Added');
        }catch(Exception $e){
          return redirect()
              ->route('pengeluaran_lain.create')
              ->with('error', $e->toString());
        }
    }

    public function ViewDestroy($id)
    {
        try {
            $lain_view = PoLainDetail::findOrFail($id);
            PoLainDetail::whereId($id)->delete();
            return redirect()
            ->route('pengeluaran_lain.show',$lain_view->polain_id)
                ->with('success','Successfully PurchaseOrder Delete');;
    
            }catch(Exception $e){
              return redirect()
                ->route('pengeluaran_lain.index')
                ->with('error', 'Failed PurchaseOrder Delete');
            }
    }
}
