<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialKontradiksi extends Model
{
    protected $table = 'material_kontradiksi';
    public $incrementing = false;
    protected $fillable = ['id','material_id','material_kontradiksi_id'];    
    

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }
}
