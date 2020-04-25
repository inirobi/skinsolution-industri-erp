<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoMaterial extends Model
{
    protected $table = 'po_materials';
    protected $guarded  = ['id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }    

}