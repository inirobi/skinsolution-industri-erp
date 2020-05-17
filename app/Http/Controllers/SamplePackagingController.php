<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SamplePackagings;
use App\Suppliers;

class SamplePackagingController extends Controller
{
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
        $tamp = SamplePackagings::orderBy('updated_at', 'desc')->get();
        return view('inventory.samples.packaging.index',['samples'=> $tamp, 'no'=>1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Suppliers::All();
        return view('inventory.samples.packaging.create',['suppliers'=> $suppliers]);
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
            'packaging_code' => 'required',
            'cas_num' => 'required',
            'packaging_name' => 'required',
            'inci_name' => 'required',
            'supplier_id' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        try {
            $req = $request->all();
            SamplePackagings::create([
                'id' => null,
                'packaging_code' => $req['packaging_code'],
                'cas_num' => $req['cas_num'],
                'packaging_name' => $req['packaging_name'],
                'inci_name' => $req['inci_name'],
                'supplier_id' => $req['supplier_id'],
                'category' => $req['category'],
                'price' => $req['price'],
              ]);
          return redirect()
              ->route('samples_packaging.index')
              ->with('success', 'Data sample packaging berhasil disimpan.');

        }catch(Exception $e){
          return redirect()
              ->route('samples_packaging.create')
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
            $samples = SamplePackagings::findOrFail($id);
            return view('inventory.samples.packaging.create', ['samples' => $samples, 'suppliers' => $suppliers]);
  
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
        return redirect()
            ->route('samples_packaging.index')
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
            'packaging_code' => 'required',
            'cas_num' => 'required',
            'packaging_name' => 'required',
            'inci_name' => 'required',
            'supplier_id' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        try {
          $req = $request->all();
          $samples = SamplePackagings::findOrFail($id);
          $samples->packaging_code = $req['packaging_code'];
          $samples->cas_num = $req['cas_num'];
          $samples->packaging_name = $req['packaging_name'];
          $samples->inci_name = $req['inci_name'];
          $samples->supplier_id = $req['supplier_id'];
          $samples->category = $req['category'];
          $samples->price = $req['price'];
          $samples->save();

          return redirect()
              ->route('samples_packaging.index')
              ->with('success', 'Data sample berhasil diupdate.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('samples_packaging.index')
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
            $samples = SamplePackagings::findOrFail($id)->delete();
            return redirect()
                ->route('samples_packaging.index')
                ->with('success', 'Data samples packaging berhasil dihapus.');
  
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('samples_packaging.index')
                ->with('error', 'Data tidak ditemukan.');
        }
    }

    public function dataStock()
    {
        $stocks = DB::table('sample_packaging_stocks')
            ->join('sample_packagings', 'sample_packaging_stocks.sample_packaging_id', '=', 'sample_packagings.id')
            ->join('suppliers', 'sample_packagings.supplier_id', '=', 'suppliers.id')
            ->select('sample_packaging_stocks.*', 'sample_packagings.packaging_code', 'sample_packagings.packaging_name', 'suppliers.supplier_name')
            ->orderBy('sample_packaging_stocks.updated_at', 'desc')
            ->get();
        return view('inventory.samples.packaging.stocks',['stocks'=> $stocks, 'no'=>1]);
    }
}
