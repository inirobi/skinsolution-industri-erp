<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materials;
use Illuminate\Support\Facades\DB;

class MaterialsController extends Controller
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
        $tamp = Materials::orderBy('updated_at', 'desc')->get();
        return view('inventory.bahan_baku.index',['materials'=> $tamp, 'no'=>1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.bahan_baku.create');
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
            'stock_minimum' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        try {
            $req = $request->all();
            Materials::create([
                'id' => null,
                'material_code' => $req['material_code'],
                'cas_num' => $req['cas_num'],
                'material_name' => $req['material_name'],
                'inci_name' => $req['inci_name'],
                'stock_minimum' => $req['stock_minimum'],
                'category' => $req['category'],
                'price' => $req['price'],
              ]);
          return redirect()
              ->route('materials.index')
              ->with('success', 'Data bahan baku berhasil disimpan.');

        }catch(Exception $e){
          return redirect()
              ->route('materials.create')
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
            $materials = Materials::findOrFail($id);
            return view('inventory.bahan_baku.create', ['materials' => $materials]);
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('materials.index')
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
            'stock_minimum' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        try {
          $req = $request->all();
          $materials = Materials::findOrFail($id);
          $materials->material_code = $req['material_code'];
          $materials->cas_num = $req['cas_num'];
          $materials->material_name = $req['material_name'];
          $materials->inci_name = $req['inci_name'];
          $materials->stock_minimum = $req['stock_minimum'];
          $materials->category = $req['category'];
          $materials->price = $req['price'];
          $materials->save();

          return redirect()
              ->route('materials.index')
              ->with('success', 'Data bahan baku berhasil diupdate.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('materials.index')
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
            $materials = Materials::findOrFail($id)->delete();
  
            return redirect()
                ->route('materials.index')
                ->with('success', 'Data bahan baku berhasil dihapus.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('materials.index')
                ->with('error', 'Data tidak ditemukan.');
          }
    }

    public function dataStock()
    {
        $stocks = DB::table('stocks')
            ->join('materials', 'stocks.material_id', '=', 'materials.id')
            ->select('stocks.*', 'materials.material_code', 'materials.material_name')
            ->orderBy('materials.updated_at', 'desc')
            ->get();
        return view('inventory.bahan_baku.stocks',['stocks'=> $stocks, 'no'=>1]);
    }
}
