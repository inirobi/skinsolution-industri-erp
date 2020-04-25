<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrialData extends Model
{
    protected $table = 'trial_datas';
    protected $guarded  = ['id'];

    public function po_customer()
    {
        return $this->belongsTo(PoCustomer::class,'po_customer_id');
    }    

    public function po_customer_detail()
    {
        return $this->belongsTo(PoCustomerDetail::class,'po_customer_detail_id');
    }    

}