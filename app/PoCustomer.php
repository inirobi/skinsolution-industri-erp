<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoCustomer extends Model
{
    protected $table = 'po_customers';
    protected $guarded  = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }    

}