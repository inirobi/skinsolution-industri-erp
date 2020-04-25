<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suppliers;

class SuppliersController extends Controller
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
        $tamp = Suppliers::orderBy('updated_at', 'desc')->get();
        return view('inventory.suppliers.index',['suppliers'=> $tamp, 'no'=>1]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.suppliers.create');
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
            'supplier_code' => 'required',
            'supplier_name' => 'required',
            'supplier_mobile' => 'required',
            'supplier_email' => 'required',
            'supplier_address' => 'required',
            'contact_person' => 'required',
        ]);

        try {
            $req = $request->all();
            Suppliers::create([
                'id' => null,
                'supplier_code' => $req['supplier_code'],
                'supplier_name' => $req['supplier_name'],
                'supplier_mobile' => $req['supplier_mobile'],
                'supplier_email' => $req['supplier_email'],
                'supplier_address' => $req['supplier_address'],
                'contact_person' => $req['contact_person'],
              ]);
          return redirect()
              ->route('suppliers.index')
              ->with('success', 'Data suppliers berhasil disimpan.');

        }catch(Exception $e){
          return redirect()
              ->route('suppliers.create')
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
        try {
            $suppliers = suppliers::findOrFail($id);
            return view('inventory.suppliers.create', ['suppliers' => $suppliers]);
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('suppliers.index')
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
            'supplier_code' => 'required',
            'supplier_name' => 'required',
            'supplier_mobile' => 'required',
            'supplier_email' => 'required',
            'supplier_address' => 'required',
            'contact_person' => 'required',
        ]);

        try {
          $req = $request->all();
          $suppliers = Suppliers::findOrFail($id);
          $suppliers->supplier_code = $req['supplier_code'];
          $suppliers->supplier_name = $req['supplier_name'];
          $suppliers->supplier_mobile = $req['supplier_mobile'];
          $suppliers->supplier_email = $req['supplier_email'];
          $suppliers->supplier_address = $req['supplier_address'];
          $suppliers->contact_person = $req['contact_person'];
          $suppliers->save();

          return redirect()
              ->route('suppliers.index')
              ->with('success', 'Data suppliers berhasil diupdate.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('suppliers.index')
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
            $suppliers = suppliers::findOrFail($id)->delete();
  
            return redirect()
                ->route('suppliers.index')
                ->with('success', 'Data suppliers berhasil dihapus.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('suppliers.index')
                ->with('error', 'Data tidak ditemukan.');
          }
    }
}
