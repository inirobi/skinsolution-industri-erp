<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoPackaging extends Model
{
    protected $table = 'po_packagings';
    protected $guarded  = ['id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault();
    }

}
