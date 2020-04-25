<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderDetail extends Model
{
    protected $table = 'delivery_order_details';
    protected $guarded  = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

}
