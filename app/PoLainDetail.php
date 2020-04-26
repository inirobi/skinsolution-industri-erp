<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoLainDetail extends Model
{
    protected $table = 'po_lain_details';
    protected $guarded  = ['id'];

    public function po_lain()
    {
        return $this->belongsTo(PoProduct::class,'polain_id');
    }    

}