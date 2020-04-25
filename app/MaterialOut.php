<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialOut extends Model
{
    protected $table = 'pengeluaran_material';
    protected $guarded  = ['id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }    

}