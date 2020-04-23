<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('penggajian.gaji');
    }

    public function error()
    {
        return view('error.page-not-found');
        // return view('welcome');
    }
}
