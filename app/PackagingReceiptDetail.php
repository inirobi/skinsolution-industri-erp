<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagingReceiptDetail extends Model
{
    protected $table = 'packaging_receipt_details';
    protected $guarded  = ['id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault();
    }

    public function packaging()
    {
        return $this->belongsTo(Packaging::class)->withDefault();
    }


}
