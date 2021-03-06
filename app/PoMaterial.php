<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoMaterial extends Model
{
    protected $table = 'po_materials';

    protected $fillable = ['id','po_num','po_date','tempo','supplier_id','currency','kurs', 'ppn', 'description', 'terms', 'status'];   
    // protected $guarded  = ['id'];

    public function suppliers()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id', 'id');
    }
}
 