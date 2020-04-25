<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
  protected $table = 'formulas';
  protected $guarded  = ['id'];

  public function revision()
  {
      return $this->belongsTo(TrialRevisionData::class,'trial_revision_data_id');
  }    

}
