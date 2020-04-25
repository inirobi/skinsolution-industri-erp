<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;

class CustomersController extends Controller
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
        $tamp = Customers::orderBy('updated_at', 'desc')->get();
        return view('pemesanan.customers.index',['customers'=> $tamp, 'no'=>1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pemesanan.customers.create');
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
            'customer_code' => 'required',
            'customer_name' => 'required',
            'customer_mobile' => 'required',
            'customer_email' => 'required',
            'customer_address' => 'required',
        ]);

        try {
            $req = $request->all();
            Customers::create([
                'id' => null,
                'customer_code' => $req['customer_code'],
                'customer_name' => $req['customer_name'],
                'customer_mobile' => $req['customer_mobile'],
                'customer_email' => $req['customer_email'],
                'customer_address' => $req['customer_address'],
              ]);
          return redirect()
              ->route('customers.index')
              ->with('success', 'Data customers berhasil disimpan.');

        }catch(Exception $e){
          return redirect()
              ->route('customers.create')
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
            $customers = Customers::findOrFail($id);
            return view('pemesanan.customers.create', ['customers' => $customers]);
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('customers.index')
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
            'customer_code' => 'required',
            'customer_name' => 'required',
            'customer_mobile' => 'required',
            'customer_email' => 'required',
            'customer_address' => 'required',
        ]);

        try {
          $req = $request->all();
          $customer = Customers::findOrFail($id);
          $customer->customer_code = $req['customer_code'];
          $customer->customer_name = $req['customer_name'];
          $customer->customer_mobile = $req['customer_mobile'];
          $customer->customer_email = $req['customer_email'];
          $customer->customer_address = $req['customer_address'];
          $customer->save();

          return redirect()
              ->route('customers.index')
              ->with('success', 'Data customers berhasil diupdate.');

        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return redirect()
              ->route('customers.index')
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
            $Customers = Customers::findOrFail($id)->delete();
  
            return redirect()
                ->route('customers.index')
                ->with('success', 'Data Customers berhasil dihapus.');
  
          } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return redirect()
                ->route('customers.index')
                ->with('error', 'Data tidak ditemukan.');
          }
    }
}
