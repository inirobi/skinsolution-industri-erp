<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    public $incrementing = false;
    protected $fillable = ['id','customer_code','customer_name','customer_mobile','customer_email','customer_address'];
}
