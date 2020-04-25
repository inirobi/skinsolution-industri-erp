<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';
    protected $guarded  = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }    

}