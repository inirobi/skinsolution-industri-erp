<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagingActivity extends Model
{
    protected $table = 'packaging_activities';
    protected $guarded  = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }
    public function product_activity()
    {
        return $this->belongsTo(ProductActivity::class)->withDefault();
    }
    public function packaging()
    {
        return $this->belongsTo(Packaging::class)->withDefault();
    }

}
