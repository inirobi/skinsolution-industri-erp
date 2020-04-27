<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gaji;

class PengeluaranGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gaji =Gaji::orderBy('id', 'desc')->get();
        $no=1;
        return view('accounting.pengeluaran.gaji.index', compact('gaji','no'));
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
        $this->validate($request,[
            'bulan' => 'required',
            'tahun' => 'required',
            'gaji' => 'required',
        ]);

        try {
            $req = $request->all();
            Gaji::create($request->all());
            return redirect()
                ->route('pengeluaran_gaji.index')
                ->with('success', 'Successfully Salary Added');

        }catch(Exception $e){
          return redirect()
              ->route('pengeluaran_gaji.index')
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
        echo "show";
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
        echo "hai";
        $this->validate($request,[
            'bulan' => 'required',
            'tahun' => 'required',
            'gaji' => 'required',
        ]);
        try {
            Gaji::whereId($id)
                ->update([
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'gaji' => $request->gaji,
                ]);
            return redirect()
                ->route('pengeluaran_gaji.index')
                ->with('success', 'Successfully Uodated.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_gaji.index')
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
            $materials = Gaji::findOrFail($id)->delete();
  
            return redirect()
                ->route('pengeluaran_gaji.index')
                ->with('success', 'Successfully Deleted.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('pengeluaran_gaji.index')
                ->with('error', 'Data is not found.');
          }
    }
}
