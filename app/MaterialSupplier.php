<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialSupplier extends Model
{
    protected $table ="material_suppliers";
    public $incrementing = false;
    protected $fillable = ['id','material_id','supplier_id'];
}
