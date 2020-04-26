<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    public $incrementing = false;
    protected $fillable = ['id','supplier_code','supplier_name','supplier_mobile','supplier_email','supplier_address','contact_person'];

    public function packagings()
    {
        return $this->belongsToMany('App\Packagings');
    }
}
