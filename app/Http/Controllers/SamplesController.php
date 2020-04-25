<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Samples;
use App\Suppliers;

class SamplesController extends Controller
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
        $tamp = Samples::orderBy('updated_at', 'desc')->get();
        return view('inventory.samples.index',['samples'=> $tamp, 'no'=>1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Suppliers::All();
         return view('inventory.samples.create',['suppliers'=> $suppliers]);
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
            'material_code' => 'required',
            'cas_num' => 'required',
            'material_name' => 'required',
            'inci_name' => 'required',
            'supplier_id' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        try {
            $req = $request->all();
            Samples::create([
                'id' => null,
                'material_code' => $req['material_code'],
                'cas_num' => $req['cas_num'],
                'material_name' => $req['material_name'],
                'inci_name' => $req['inci_name'],
                'supplier_id' => $req['supplier_id'],
                'category' => $req['category'],
                'price' => $req['price'],
              ]);
          return redirect()
              ->route('samples.index')
              ->with('success', 'Data sample berhasil disimpan.');

        }catch(Exception $e){
          return redirect()
              ->route('samples.create')
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
            $suppliers = Suppliers::All();
            $samples = Samples::findOrFail($id);
            return view('inventory.samples.create', ['samples' => $samples, 'suppliers' => $suppliers]);
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('samples.index')
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
            'material_code' => 'required',
            'cas_num' => 'required',
            'material_name' => 'required',
            'inci_name' => 'required',
            'supplier_id' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        try {
          $req = $request->all();
          $samples = Samples::findOrFail($id);
          $samples->material_code = $req['material_code'];
          $samples->cas_num = $req['cas_num'];
          $samples->material_name = $req['material_name'];
          $samples->inci_name = $req['inci_name'];
          $samples->supplier_id = $req['supplier_id'];
          $samples->category = $req['category'];
          $samples->price = $req['price'];
          $samples->save();

          return redirect()
              ->route('samples.index')
              ->with('success', 'Data sample berhasil diupdate.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('samples.index')
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
            $samples = Samples::findOrFail($id)->delete();
  
            return redirect()
                ->route('samples.index')
                ->with('success', 'Data samples berhasil dihapus.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('samples.index')
                ->with('error', 'Data tidak ditemukan.');
          }
    }
}
