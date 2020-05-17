<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SamplePackagingOut extends Model
{
    protected $table = 'pengeluaran_sample_packaging';
    protected $guarded  = ['id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }  
}
