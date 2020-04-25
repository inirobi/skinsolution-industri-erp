<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoCustomerDetail extends Model
{
    protected $table = 'po_customer_details';
    protected $guarded  = ['id'];

    public function material()
    {
        return $this->belongsTo(PoCustomer::class,'po_customer_id');
    }    

}