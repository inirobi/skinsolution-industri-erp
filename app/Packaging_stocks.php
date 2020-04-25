<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packaging_stocks extends Model
{
    public $incrementing = false;
    protected $fillable = ['id','packaging_id','quantity'];
}
