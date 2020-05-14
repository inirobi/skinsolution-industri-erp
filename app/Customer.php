<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
      'customer_code',
      'customer_name',
      'customer_mobile',
      'customer_email',
      'customer_address',
      'customer_phone',
    ];

    public function packagingReceipt()
    {
        return $this->hasMany('App\PackagingReceipt');
    }

}
