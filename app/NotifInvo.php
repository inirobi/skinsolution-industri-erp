<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifInvo extends Model
{
    protected $table = 'notif_invo';
    protected $guarded  = ['id_invo'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault();
    }

}
