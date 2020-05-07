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
        }else if($request->jenis_po == 2){
               $tampMaterial = DB::table('po_packagings')
                ->join('po_packaging_details','po_packaging_details.po_packaging_id','po_packagings.id')
                ->join('suppliers','suppliers.id','po_packagings.supplier_id')
                ->whereBetween('po_packagings.po_date', array($startDate, $endDate))
                ->orderBy('po_packagings.po_date','ASC')
                ->get();
                $jenis_po = "PO Packaging";
        }else if($request->jenis_po == 3){
               $tampMaterial = DB::table('po_lain')
                ->join('po_lain_details','po_lain_details.polain_id','po_lain.id')
                ->join('suppliers','suppliers.id','po_lain.supplier_id')
                ->whereBetween('po_lain.po_date', array($startDate, $endDate))
                ->orderBy('po_lain.po_date','ASC')
                ->get();
                $jenis_po = "PO Lain-lain";
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
        }

       return view('laporan.pengeluaran.index',compact('tampMaterial','tamp', 'jenis_po','startDate','endDate'));
    }
    public function pemasukkan()
    {
        $tamp = 0;
        $startDate = -1;
        $endDate  = -1;
        $tampMaterial = DB::table('invoices')
        ->join('invoice_details','invoice_details.invoice_id','invoices.id')
        ->join('customers','customers.id','invoices.customer_id')
        ->whereBetween('invoices.date', array($startDate, $endDate))
        ->orderBy('invoices.date','ASC')
        ->get();
        
        $jenis_pemasukkan = "Invoice";
            
        return view('laporan.pemasukan.index',compact('tampMaterial','tamp','jenis_pemasukkan','startDate','endDate'));
    }

    public function storePemasukkan(Request $request)
    {
        
        $startDate = date('m/d/Y', strtotime($request->date_start));
        $endDate  = date('m/d/Y', strtotime($request->date_end));
        $tamp = $request->jenis_pemasukkan;
        if($request->jenis_pemasukkan == 1){
              $tampMaterial = DB::table('invoices')
                ->join('invoice_details','invoice_details.invoice_id','invoices.id')
                ->join('po_products','po_products.id','invoices.po_product_id')
                ->join('customers','customers.id','invoices.customer_id')
                ->whereBetween('invoices.date', array($startDate, $endDate))
                ->orderBy('invoices.date','ASC')
                ->get();
            $jenis_pemasukkan = "Invoice";
        }else if($request->jenis_pemasukkan == 2){
              $tampMaterial = DB::table('penjualan')
                ->whereBetween('date', array($startDate, $endDate))
                ->orderBy('date','ASC')
                ->get();
            $jenis_pemasukkan = "Penjualan";
        }
        else{
            $tamp = 0;
            $startDate = -1;
            $endDate  = -1;
            $tampMaterial = DB::table('invoices')
            ->join('invoice_details','invoice_details.invoice_id','invoices.id')
            ->join('customers','customers.id','invoices.customer_id')
            ->whereBetween('invoices.date', array($startDate, $endDate))
            ->orderBy('invoices.date','ASC')
            ->get();
             $jenis_pemasukkan = "Penjualan";
        }
      return view('laporan.pemasukan.index',compact('tampMaterial','tamp','jenis_pemasukkan','startDate','endDate'));
    }
}
