<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabellingOut extends Model
{
    protected $table = 'pengeluaran_labelling';
    protected $guarded  = ['id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }    

}