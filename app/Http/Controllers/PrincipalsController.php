<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Principals;

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
        $tamp = Principals::orderBy('updated_at', 'desc')->get();
        return view('inventory.principals.index',['principals'=> $tamp, 'no'=>1]);
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
            'address' => 'required',
            'country' => 'required',
        ]);

        try {
            $req = $request->all();
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
            'address' => 'required',
            'country' => 'required',
        ]);

        try {
          $req = $request->all();
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
}
