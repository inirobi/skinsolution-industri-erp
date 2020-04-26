<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifLain extends Model
{
    protected $table = 'notif_lain';
    protected $guarded  = ['id_lain'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault();
    }

}
