<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $table = 'invoice_details';
    protected $guarded  = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

}
