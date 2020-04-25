<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoPackagingDetail extends Model
{
    protected $table = 'po_packaging_details';
    protected $guarded  = ['id'];

    public function po_packaging()
    {
        return $this->belongsTo(PoPackaging::class)->withDefault();
    }

    public function packaging()
    {
        return $this->belongsTo(Packaging::class)->withDefault();
    }

}
