<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $table = 'purchase_order_details';
    protected $guarded  = ['id'];

    public function material()
    {
        return $this->belongsTo(PurchaseOrder::class,'purchase_order_id');
    }    

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }    

}