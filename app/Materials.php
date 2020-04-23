<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    public $incrementing = false;
    protected $fillable = ['id','material_code','cas_num','material_name','inci_name','stock_minimum','category','price'];
}
