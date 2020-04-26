<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
  public $incrementing = false;
  protected $fillable = ['id','date','purchase_num','delivery_orders_num','po_material_id'];
}
