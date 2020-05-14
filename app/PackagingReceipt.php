<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagingReceipt extends Model
{
    protected $table = 'packaging_receipts';
    protected $guarded  = ['id'];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_id');
    }
}
