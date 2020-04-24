<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packagings extends Model
{
    public $incrementing = false;
    protected $fillable = ['id','packaging_code','category','packaging_name','packaging_type','stock_minimum','category','price'];
}
