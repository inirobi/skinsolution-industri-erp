<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packagings extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'id',
        'packaging_code',
        'category',
        'packaging_name',
        'packaging_type',
        'customer_id',
        'supplier_id',
        'stock_minimum',
        'status',
        'price',
    ];

    public function customers()
    {
        return $this->belongsToMany('App\Customers', 'packaging_customer', 'packaging_id', 'customer_id');
    }
    
    public function suppliers()
    {
        return $this->belongsToMany('App\Suppliers', 'packaging_supplier', 'packaging_id', 'supplier_id');
    }
    
}
