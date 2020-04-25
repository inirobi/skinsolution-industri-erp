<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded  = ['id'];

    public function formula()
    {
        return $this->belongsTo(Formula::class,'formula_id');
    }      

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }      

    public function revision()
    {
        return $this->belongsTo(TrialRevisionData::class,'trial_revision_data_id');
    }      

}
