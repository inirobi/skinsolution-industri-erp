<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function pengeluaran()
    {
        $startDate = -1;
        $endDate  = -1;
       $tamp = 0;
        $tampMaterial = DB::table('po_materials')
        ->join('po_material_details','po_material_details.po_material_id','po_materials.id')
        ->join('suppliers','suppliers.id','po_materials.supplier_id')
        ->whereBetween('po_materials.po_date', array($startDate, $endDate))
        ->orderBy('po_materials.po_date','ASC')
        ->get();
        
        $jenis_po = "";
            Session::put('tamp',$tamp);
            Session::put('jenis_po',$jenis_po);
            Session::put('starDate',$startDate);
            Session::put('endDate',$endDate);
            Session::put('tampMaterial',$tampMaterial);
        return view('laporan.pengeluaran.index',compact('tampMaterial','tamp', 'jenis_po','startDate','endDate'));
    }

    public function storePengeluaran(Request $request)
    {
        
        $startDate = date('m/d/Y', strtotime($request->date_start));
        $endDate  = date('m/d/Y', strtotime($request->date_end));
        $tamp = $request->jenis_po;
        if($request->jenis_po == 1){
               $tampMaterial = DB::table('po_materials')
                ->join('po_material_details','po_material_details.po_material_id','po_materials.id')
                ->join('suppliers','suppliers.id','po_materials.supplier_id')
                ->whereBetween('po_materials.po_date', array($startDate, $endDate))
                ->orderBy('po_materials.po_date','ASC')
                ->get();
            $jenis_po = "PO Material";
            Session::put('tamp',$tamp);
            Session::put('jenis_po',$jenis_po);
            Session::put('starDate',$startDate);
            Session::put('endDate',$endDate);
            Session::put('tampMaterial',$tampMaterial);
        }else if($request->jenis_po == 2){
               $tampMaterial = DB::table('po_packagings')
                ->join('po_packaging_details','po_packaging_details.po_packaging_id','po_packagings.id')
                ->join('suppliers','suppliers.id','po_packagings.supplier_id')
                ->whereBetween('po_packagings.po_date', array($startDate, $endDate))
                ->orderBy('po_packagings.po_date','ASC')
                ->get();
                $jenis_po = "PO Packaging";
            Session::put('tamp',$tamp);
            Session::put('jenis_po',$jenis_po);
            Session::put('starDate',$startDate);
            Session::put('endDate',$endDate);
            Session::put('tampMaterial',$tampMaterial);
        }else if($request->jenis_po == 3){
            
               $tampMaterial = DB::table('po_lain')
                ->join('po_lain_details','po_lain_details.polain_id','po_lain.id')
                ->join('suppliers','suppliers.id','po_lain.supplier_id')
                ->whereBetween('po_lain.date', array($startDate, $endDate))
                ->orderBy('po_lain.date','ASC')
                ->get();
                $jenis_po = "PO Lain-lain";
            Session::put('tamp',$tamp);
            Session::put('jenis_po',$jenis_po);
            Session::put('starDate',$startDate);
            Session::put('endDate',$endDate);
            Session::put('tampMaterial',$tampMaterial);
        }
        else{
            $startDate = -1;
            $endDate  = -1;
            $tamp = 0;
            $tampMaterial = DB::table('po_materials')
            ->join('po_material_details','po_material_details.po_material_id','po_materials.id')
            ->join('suppliers','suppliers.id','po_materials.supplier_id')
            ->whereBetween('po_materials.po_date', array($startDate, $endDate))
            ->orderBy('po_materials.po_date','ASC')
            ->get();
            $jenis_po = "";
            Session::put('tamp',$tamp);
            Session::put('jenis_po',$jenis_po);
            Session::put('starDate',$startDate);
            Session::put('endDate',$endDate);
            Session::put('tampMaterial',$tampMaterial);
            
        }
       return view('laporan.pengeluaran.index',compact('tampMaterial','tamp', 'jenis_po','startDate','endDate'));
    }
    
}
