<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SamplePackagingPurchase extends Model
{
    protected $fillable = [
        'date',
        'purchase_num',
        'sample_packaging_id',
        'quantity',
        'price',
    ];

    public function sample_packaging()
    {
        return $this->belongsTo(SamplePackagings::class,'sample_packaging_id');
    }
}
