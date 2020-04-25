<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    protected $table = 'delivery_orders';
    protected $guarded  = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault();
    }

    public function po_product()
    {
        return $this->belongsTo(PoProduct::class)->withDefault();
    }

}
