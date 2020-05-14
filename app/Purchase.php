<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'date',
        'purchase_num',
        'delivery_orders_num',
        'po_material_id',
    ];      

    public function po_material()
    {
        return $this->belongsTo(PoMaterial::class,'po_material_id');
    }    


}
