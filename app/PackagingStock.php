<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagingStock extends Model
{
    protected $table = 'packaging_stocks';
    protected $guarded  = ['id'];

    public function packaging()
    {
        return $this->belongsTo(Packaging::class)->withDefault();
    }

}
