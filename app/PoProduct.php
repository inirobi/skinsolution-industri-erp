<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoProduct extends Model
{
    protected $table = 'po_products';
    protected $guarded  = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }    

}