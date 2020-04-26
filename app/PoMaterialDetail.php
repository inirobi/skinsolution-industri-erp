<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoMaterialDetail extends Model
{
    protected $table = 'po_material_details';
    public $incrementing = false;
    protected $fillable = ['id','po_material_id','material_id','quantity','price'];    
}
