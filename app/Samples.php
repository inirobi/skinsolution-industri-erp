<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Samples extends Model
{
    protected $table = 'sample_materials';
    public $incrementing = false;
    protected $fillable = ['id','material_code','cas_num','material_name','inci_name','supplier_id','category','price'];
}
