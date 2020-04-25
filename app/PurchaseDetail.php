<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table = 'purchase_details';
    protected $guarded  = ['id'];

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }    

    public function purchase()
    {
        return $this->belongsTo(Purchase::class,'purchase_id');
    }    

}