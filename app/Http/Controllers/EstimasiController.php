<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Materials;
use App\Packagings;

class EstimasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $materials = Materials::orderBy('updated_at', 'desc')->get();
        $datas[] = [];
        $idx = 0;

        $now = strtotime(now());
        $today = date('Y-m-d', $now);
        $newdate = date('Y-m-d', strtotime('-6 month', $now));

        foreach ($materials as $data) {
            
            $sum2 = DB::table('formulas')
                ->join('formula_details','formula_details.formula_id','=','formulas.id')
                ->where('formula_details.material_id',$data->id)
                ->whereBetween('formulas.created_at',[$newdate,$today])
                ->sum('weighing');
            
            $sum3 = DB::table('product_activities')
                ->join('product_activity_details','product_activities.id','=','product_activity_details.product_activity_id')
                ->where('product_activity_details.material_id',$data->id)
                ->whereBetween('product_activities.created_at',[$newdate,$today])
                ->sum('weighing');
                
            $sum4 = DB::table('pengeluaran_material')
                ->where('material_id',$data->id)
                ->whereBetween('pengeluaran_material.created_at',[$newdate,$today])
                ->sum('quantity');
            
            $keluar = $sum2 + $sum3 + $sum4;
            $datas[$idx] = [$data->material_name,$keluar];
            $idx++;
        }

        $no = 1;
        return view('inventory.estimasi.material.index',compact('no','datas'));
    }
    public function index2()
    {
        $packagings = Packagings::orderBy('updated_at', 'desc')->get();
        $datas[] = [];
        $idx = 0;

        $now = strtotime(now());
        $today = date('Y-m-d', $now);
        $newdate = date('Y-m-d', strtotime('-6 month', $now));

        foreach ($packagings as $data) {
            
            $sum3 = DB::table('products')
                ->join('packaging_activities','products.id','packaging_activities.product_id')
                ->join('packagings','products.id_packaging','packagings.id')
                ->whereBetween('products.created_at',[$newdate,$today])
                ->where([
                    ['packaging_activities.status','=','Release'],
                    ['packagings.id',$data->id]
                ])->sum('used_quantity');
                
            $sum4 = DB::table('pengeluaran_packaging')
                    ->where('packaging_id',$data->id)
                    ->whereBetween('pengeluaran_packaging.created_at',[$newdate,$today])
                    ->sum('quantity');
            $keluar = $sum3 + $sum4;
            $datas[$idx] = [$data->packaging_name,$keluar];
            $idx++;
        }

        $no = 1;
        return view('inventory.estimasi.packaging.index',compact('no','datas'));
    }
}
