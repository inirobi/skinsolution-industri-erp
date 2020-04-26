<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    protected $table = 'packagings';
    protected $guarded  = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault();
    }

}
