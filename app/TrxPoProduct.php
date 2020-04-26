<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrxPoProduct extends Model
{
    protected $table = 'trx_po_product_details';
    protected $guarded  = ['id'];

    public function po_product()
    {
        return $this->belongsTo(PoProduct::class,'po_product_id');
    }    

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }    

}