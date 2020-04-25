<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
      'material_code',
      'cas_num',
      'material_name',
      'inci_name',
      'supplier_id',
      'stock_minimum',
      'category',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault();
    }
}
