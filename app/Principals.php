<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principals extends Model
{
    public $incrementing = false;
    protected $fillable = ['id','principal_code','name','address','country'];
}
