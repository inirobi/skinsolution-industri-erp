<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleStock extends Model
{
    protected $fillable = [
      'sample_material_id',
      'quantity',
    ];

    public function sample_material()
    {
        return $this->belongsTo(SampleMaterial::class,'sample_material_id');
    } 


}
