<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoMaterialDetail extends Model
{
    protected $table = 'po_material_details';
    protected $guarded  = ['id'];

    public function po_material()
    {
        return $this->belongsTo(PoMaterial::class,'po_material_id');
    }    

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }    

}