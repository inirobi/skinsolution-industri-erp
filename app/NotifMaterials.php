<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifMaterials extends Model
{
    protected $table = 'notif_material';
    protected $guarded  = ['id_material'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }    

}