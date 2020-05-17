<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RnD extends Model
{
    protected $table = 'rnd';
    protected $guarded  = ['id'];

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }    
}
