<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employees;
use App\Gaji;

class PenggajianController extends Controller
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
  public function pegawai()
  {
    $tamp = Employees::all();
    return view('penggajian.pegawai',['employees'=> $tamp, 'no'=>1]);
  }

  public function gaji()
  {
    $tamp = Gaji::all();
    return view('penggajian.gaji',['gaji'=> $tamp, 'no'=>1]);
  }
    
}
