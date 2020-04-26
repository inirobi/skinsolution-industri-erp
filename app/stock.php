<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
      'material_id',
      'quantity',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class)->withDefault();
    }


}
