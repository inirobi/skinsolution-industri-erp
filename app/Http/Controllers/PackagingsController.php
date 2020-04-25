<?php

namespace App\Http\Controllers;

use App\Packagings;
use Illuminate\Http\Request;

class PackagingsController extends Controller
{
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
}
