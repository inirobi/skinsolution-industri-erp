<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employees;
use App\Gaji;

class PenggajianController extends Controller
{
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
