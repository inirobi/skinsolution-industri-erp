<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrincipalSupplier extends Model
{
    protected $table ="principal_suppliers";
    public $incrementing = false;
    protected $fillable = ['id','principal_id','supplier_id'];
}
