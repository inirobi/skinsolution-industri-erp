<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SamplePurchase extends Model
{
    protected $fillable = [
        'date',
        'purchase_num',
        'sample_material_id',
        'quantity',
        'price',
    ];

    public function sample_material()
    {
        return $this->belongsTo(SampleMaterial::class,'sample_material_id');
    }    


}
