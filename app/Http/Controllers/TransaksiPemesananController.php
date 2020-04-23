<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiPemesananController extends Controller
{
  public function index()
  {
    return view('welcome');
  }
  public function customer()
  {
    return view('pemesanan.customer');
  }
}
