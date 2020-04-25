<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductActivity extends Model
{
    protected $table = 'product_activities';
    protected $guarded  = ['id'];

    public function po_product()
    {
        return $this->belongsTo(PoProduct::class,'po_product_id');
    }      

}
