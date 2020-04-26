<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table = 'purchase_details';
    public $incrementing = false;
  protected $fillable = ['id','purchase_id','material_id','quantity','expired_date', 'batch_num','analis_num'];
}
