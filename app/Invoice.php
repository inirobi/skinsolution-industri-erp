<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
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
