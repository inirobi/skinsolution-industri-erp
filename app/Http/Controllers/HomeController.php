<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page_title = "Dashboard";
        $total_customer = DB::table('customers')->count();
        $total_supplier = DB::table('suppliers')->count();
        $total_material = DB::table('materials')->count();
        $total_product = DB::table('products')->count();
 
        return view('home',compact('page_title','total_customer','total_supplier','total_material','total_product'));
    }
}
