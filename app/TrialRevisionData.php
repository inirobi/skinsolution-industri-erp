<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrialRevisionData extends Model
{
    protected $table = 'trial_revision_datas';
    protected $guarded  = ['id'];

    public function trial()
    {
        return $this->belongsTo(TrialData::class,'trial_data_id');
    }    

}