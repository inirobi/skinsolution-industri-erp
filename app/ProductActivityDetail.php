<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductActivityDetail extends Model
{
    protected $table = 'product_activity_details';
    protected $guarded  = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }      

    public function product_activity()
    {
        return $this->belongsTo(ProductActivity::class,'product_activity_id');
    }      

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }      

    public function sample_material()
    {
        return $this->belongsTo(SampleMaterial::class,'material_id');
    }      

}
