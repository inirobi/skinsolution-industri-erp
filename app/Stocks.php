<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    public $incrementing = false;
    protected $fillable = ['id','material_id','Quantity'];
}
