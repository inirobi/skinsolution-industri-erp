<?php

namespace App\Http\Controllers;

use App\Packagings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackagingsController extends Controller
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
    public function index(Request $request)
    {
        return view('inventory.packagings.index');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.packagings.index');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Packagings  $packagings
     * @return \Illuminate\Http\Response
     */
    public function show(Packagings $packagings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Packagings  $packagings
     * @return \Illuminate\Http\Response
     */
    public function edit(Packagings $packagings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Packagings  $packagings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Packagings $packagings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Packagings  $packagings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Packagings $packagings)
    {
        //
    }

    public function dataStock()
    {
        $stocks = DB::table('packaging_stocks')
            ->join('packagings', 'packaging_stocks.packaging_id', '=', 'packagings.id')
            ->select('packaging_stocks.*', 'packagings.packaging_code', 'packagings.packaging_name', 'packagings.packaging_type')
            ->orderBy('packagings.updated_at', 'desc')
            ->get();
        return view('inventory.packagings.stocks',['stocks'=> $stocks, 'no'=>1]);
    }
}
