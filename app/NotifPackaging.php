<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifPackaging extends Model
{
    protected $table = 'notif_pack';
    protected $guarded  = ['id_packaging'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault();
    }

}
