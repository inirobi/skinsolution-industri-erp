<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PoMaterial;
use App\PoMaterialDetail;
use App\Suppliers;
use App\Material;
use App\NotifMaterials;
use App\MaterialSupplier;
use App\Petty;
use App\Materials;
use Illuminate\Support\Facades\DB;

class PoMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase= DB::table('po_materials')
        ->select('po_materials.*','suppliers.supplier_name')
        ->join('suppliers','suppliers.id','=','po_materials.supplier_id')
        ->orderBy('po_materials.updated_at', 'desc')->get();
        return view('inventory.purchases.po_materials.index', ['purchase' =>$purchase, 'no'=>1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = Suppliers::all();
        return view('inventory.purchases.po_materials.create',compact('supplier'));
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
            'date' => 'required',
            'supplier_id' => 'required',
            'terms' => 'required',
            'currency' => 'required',
        ]);
        try{
            $cek = DB::table('po_materials')
            ->where('po_num',$request->po_num)
            ->count();
            
            if($cek > 0){
                return redirect()
                    ->route('po_material.create')
                    ->with('error','Code Already Exists!!');
            }
            date_default_timezone_set('Asia/Jakarta');   
            if($request->terms == "7 Days"){
                $tempo = date('m/d/Y ', strtotime('+1 friday', strtotime($request->date)));    
            }
            else if($request->terms == "14 Days"){
                $tempo = date('m/d/Y', strtotime('+2 friday', strtotime($request->date)));    
            }
            else if($request->terms == "30 Days"){
                $tempo = date('m/d/Y', strtotime('+4 friday', strtotime($request->date)));
            }
            else if($request->terms == "Cash"){
                $tempo = "00-00-0000";
            }
            
            if($request->terms=='Cash'){
                $status='Paid';
                $petty=new Petty();
                $petty->date= $date;
                $petty->money='0';
                $petty->status='0';
                $petty->saldo='0';
                $petty->keterangan='Pembayaran PO Material';
                $petty->save();
            }else{
                $status='Unpaid';
            }
            $PoMaterial=new PoMaterial();
            $PoMaterial->po_num=$request->po_num;
            $PoMaterial->supplier_id=$request->supplier_id;
            $PoMaterial->currency=$request->currency;
            $PoMaterial->po_date=$request->date;
            $PoMaterial->tempo=$tempo;
            $PoMaterial->ppn=$request->ppn;
            $PoMaterial->kurs=$request->kurs;
            $PoMaterial->description=$request->description;
            $PoMaterial->terms=$request->terms;
            $PoMaterial->status=$status;
            $PoMaterial->save();
            
            return redirect()
                ->route('po_material.index')
                ->with('success','Successfully PurchaseOrder Material Added');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
              ->route('po_material.index')
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
        $purchase = PoMaterial::findOrFail($id);
        $materialSupplier = MaterialSupplier::where('supplier_id', $purchase->supplier_id)->get();
        $matId = array();
        foreach($materialSupplier as $data){
            $matId[] = $data->material_id;
        }
        $material = DB::table('materials')
                    ->whereIn('id', $matId)
                    ->get();
        $purchase_view = PoMaterialDetail::where('po_material_id', $id)->get();
        
        $materials = Materials::all();
        $supplier = Suppliers::all();
        return view('inventory.purchases.po_materials.detail',compact('purchase','material','purchase_view'));
    }

    public function ViewStore(Request $request)
    {
        PoMaterialDetail::create($request->all());
        $material = Material::findOrFail($request->material_id);
        $po = PoMaterial::findOrFail($request->po_material_id);
        $price = $request->price / 1000;
        if($po->currency=='USD'){$price = $price * $po->kurs;}
        if($material->price < $price){
            Material::whereId($request->material_id)
            ->update([
                'price' => $price,
            ]);        

        }

           if($po->status=='Paid'){
                $poPackagingdetail = PoMaterialDetail::where('po_material_id', $request->po_material_id)->get(); 
                $total = ($request->quantity * $request->price);
                $PPN = 0;
            
                $total = 0;
        
                foreach ($poPackagingdetail as $dataDetail) {
                    echo $price=$dataDetail->price;
                    echo $po->currency;
                    echo $po->kurs;
                    if($po->currency=='USD'){$price = $price * $po->kurs;}
                echo  $total = $total + ($dataDetail->quantity * $price);
                    
                }
                
                $PPN = 0.10 * $total;
                if($po->ppn=='1'){
                $total = $total + $PPN;
            }
          
             $petty=Petty::where('date',$po->po_date)->get();
               foreach($petty as $dd){
                $dd->date= $po->po_date;
                $dd->money=$total;
                $dd->status='0';
                $dd->saldo='0';
                $dd->keterangan='Pembayaran PO Material';
                $dd->update();
            }
           
        }
      return redirect()
        ->route('po_material.show',$request->input('po_material_id'))
        ->with('success','Successfully PurchaseOrder Added');
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = PoMaterial::findOrFail($id);
        $supplier = Suppliers::all();
        return view('inventory.purchases.po_materials.create', compact('purchase','supplier'));
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
            'date' => 'required',
        ]);
        try {
            $kurs = $request->kurs;
            if ($request->currency == 'IDR') {
                $kurs = '';
            }
            PoMaterial::whereId($id)
                ->update([
                    'po_num' => $request->po_num,
                    'po_date' => $request->date,
                    'currency' => $request->currency,
                    'supplier_id' => $request->supplier_id,
                    'kurs' => $kurs,
                    'ppn' => $request->ppn,
                    'description' => $request->description,
                ]); 
          
          return redirect()
            ->route('po_material.index')
            ->with('success', 'Successfully Updated.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
            ->route('po_material.index')
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
        try{

            PoMaterialDetail::where('po_material_id',$id)->delete();
            PoMaterial::whereId($id)->delete();
            
            return redirect()
                ->route('po_material.index')
                ->with('success','Successfully PurchaseOrder Delete');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('po_material.index')
                ->with('error', 'Data is not found.');
        }
    }

    public function print($id) 
    {
        $purchase = PoMaterial::findOrFail($id);
        $purchase_view = PoMaterialDetail::where('po_material_id', $id)->get();
        return view('inventory.purchases.po_materials.print', compact('purchase','purchase_view'));
    }
    
    public function destroyView($id)
    {
        try{
            $purchase = PoMaterialDetail::findOrFail($id);
            PoMaterialDetail::whereId($id)->delete();
            return redirect()
                ->route('po_material.show',$purchase->po_material_id)
                ->with('success','Successfully PurchaseOrder Delete');
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('po_material.index')
                ->with('error', 'Data is not found.');
            }
    }

    public function pengeluaran_material()
    {
        // $purchase = PoMaterial::orderBy('id', 'desc')->get();
        $purchase = DB::table('po_materials')
                    ->select('po_materials.*','suppliers.supplier_name') 
                    ->join('suppliers','po_materials.supplier_id','=','suppliers.id')
                    ->orderBy('po_materials.id','desc')
                    ->get();
        // $supplier = Suppliers::all();
         // $notifmat=NotifMaterials::all();
        // return view('accounting.pengeluaran.material.index', compact('purchase','supplier'));
        return view('accounting.pengeluaran.material.index', compact('purchase'));
    }
    public function pengeluaran_material_detail($id)
    {
        $purchase = PoMaterial::findOrFail($id);
        $materialSupplier = MaterialSupplier::where('supplier_id', $purchase->supplier_id)->get();
        $matId = array();
        foreach($materialSupplier as $data){
            $matId[] = $data->material_id;
        }

        $material = DB::table('materials')
                    ->whereIn('id', $matId)
                    ->get();

        $purchase_view = PoMaterialDetail::where('po_material_id', $id)->get();
        return view('accounting.pengeluaran.material.view', compact('purchase', 'purchase_view', 'material'));
    }
    public function pengeluaran_material_update(Request $request)
    {
        try {
            
            DB::table('po_materials')
              ->where('id', $request->kode)
              ->update(['status' => $request->status]); 
          
          return redirect('accounting_POmaterial')
              ->with('success', 'Successfully Updated.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect('accounting_POmaterial')
              ->with('error', 'Data is not found.');
        }
    }
}
