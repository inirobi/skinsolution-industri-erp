<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoLain extends Model
{
    protected $table = 'po_lain';
    protected $guarded  = ['id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault();
    }

}
