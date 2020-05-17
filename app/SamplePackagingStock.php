<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SamplePackagingStock extends Model
{
    protected $fillable = [
        'sample_packaging_id',
        'quantity',
      ];
  
      public function sample_packaging()
      {
          return $this->belongsTo(SamplePackagings::class,'sample_packaging_id');
      } 
}
