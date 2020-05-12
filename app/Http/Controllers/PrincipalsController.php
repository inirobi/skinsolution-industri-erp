<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Principals;
use App\PrincipalSupplier;
use App\Suppliers;
use Illuminate\Support\Facades\DB;

class PrincipalsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sup = DB::table('principal_suppliers')
        ->join('suppliers','principal_suppliers.supplier_id','suppliers.id')
        ->get();
        $nomor=1;
        $pcl =DB::table('principals as a')->selectRaw('a.*, count(b.supplier_id) as count')->Leftjoin('principal_suppliers as b','a.id','=','b.principal_id')->groupBy('b.principal_id')->get();
        $principals = Principals::orderBy('updated_at', 'desc')->get();
        return view('inventory.principals.index',compact('principals', 'nomor', 'pcl', 'sup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('inventory.principals.create');
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
            'principal_code' => 'required',
            'name' => 'required',
        ]);

        try {
            $req = $request->all();
            if (!isset($req['address'])) {
                $req['address'] = '';
            }
            if (!isset($req['country'])) {
                $req['country'] = '';
            }
            Principals::create([
                'id' => null,
                'principal_code' => $req['principal_code'],
                'name' => $req['name'],
                'address' => $req['address'],
                'country' => $req['country'],
              ]);
          return redirect()
              ->route('principals.index')
              ->with('success', 'Data principal berhasil disimpan.');

        }catch(Exception $e){
          return redirect()
              ->route('principals.create')
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
        $sup= DB::table('principal_suppliers')
        ->select('principal_suppliers.*','suppliers.*','principals.*')
        ->join('suppliers','suppliers.id','=','principal_suppliers.supplier_id')
        ->join('principals','principals.id','=','principal_suppliers.principal_id')
        ->selectRaw('principal_suppliers.id as id_x')
        ->where('principal_suppliers.principal_id',$id)->get();

        $supplier= Suppliers::all();
        return view('inventory.principals.supplier',['sup' => $sup, 'id' => $id, 'supplier' => $supplier]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $principals = Principals::findOrFail($id);
            return view('inventory.principals.create', ['principals' => $principals]);
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('principals.index')
                ->with('error', 'Data tidak ditemukan.');
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
        $this->validate($request,[
            'principal_code' => 'required',
            'name' => 'required',
        ]);

        try {
          $req = $request->all();
          if (!isset($req['address'])) {
            $req['address'] = '';
            }
            if (!isset($req['country'])) {
                $req['country'] = '';
            }
          $principal = Principals::findOrFail($id);
          $principal->principal_code = $req['principal_code'];
          $principal->name = $req['name'];
          $principal->address = $req['address'];
          $principal->country = $req['country'];
          $principal->save();

          return redirect()
              ->route('principals.index')
              ->with('success', 'Data principal berhasil diupdate.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('principals.index')
              ->with('error', 'Data tidak ditemukan.');
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
            $principals = Principals::findOrFail($id)->delete();
  
            return redirect()
                ->route('principals.index')
                ->with('success', 'Data principal berhasil dihapus.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('principals.index')
                ->with('error', 'Data tidak ditemukan.');
          }
    }

    // suppliers

    public function supplierStore(Request $request)
    {
        $x = DB::table('principal_suppliers')->where([
                ['supplier_id', '=', $request->supplier_id],
                ['principal_id', '=', $request->principal_id],
            ])->count();
        if($x>0){
            return redirect()->back()->with('error', 'Supplier Already Exist');
        }
        else{
            $sup = PrincipalSupplier::create([
                'id' => null,
                'principal_id' => $request->principal_id,
                'supplier_id' => $request->supplier_id,
            ]);
            return redirect()->back()->with('success', 'Data principal berhasil dihapus.');
        }
        
    }

    public function SupplierDelete($id)
    {

        try {
            PrincipalSupplier::whereId($id)->delete();
            return redirect()->back()->with('success', 'Successfully Deleted.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('materials.index')
                ->with('error', 'Data is not found.');
          }   
    }
}
