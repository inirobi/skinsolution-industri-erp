<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labelling extends Model
{
    protected $table = 'labellings';
    protected $guarded  = ['id'];

    public function packaging_activity()
    {
        return $this->belongsTo(PackagingActivity::class)->withDefault();
    }

}
