<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SamplePackagings extends Model
{
    protected $fillable = [
        'packaging_code',
        'cas_num',
        'packaging_name',
        'inci_name',
        'supplier_id',
        'category',
        'price',
     ];
  
      public function supplier()
      {
          return $this->belongsTo(Supplier::class)->withDefault();
      }
}
