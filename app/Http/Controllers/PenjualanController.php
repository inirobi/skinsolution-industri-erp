<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan =Penjualan::orderBy('id', 'desc')->get();
        $no=1;
        return view('accounting.pemasukan.penjualan.index', compact('penjualan','no'));
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
        try {
            Penjualan::create($request->all());
            return redirect()
                ->route('penjualan.index')
                ->with('success', 'Successfully Salary Added');

        }catch(Exception $e){
          return redirect()
              ->route('penjualan.index')
              ->with('error', 'Failed Salary Added');
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
        try {
            Penjualan::whereId($id)
            ->update([
                'date' => $request->date,
                'keterangan' => $request->keterangan,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'penjualan' => $request->penjualan
            ]);
            return redirect()
                ->route('penjualan.index')
                ->with('success', 'Successfully Uodated.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('penjualan.index')
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
        try {
            Penjualan::whereId($id)->delete();
            return redirect()
                ->route('penjualan.index')
                ->with('success', 'Successfully Deleted.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('penjualan.index')
                ->with('error', 'Data is not found.');
        }
    }
}
