<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal extends Model
{
    protected $table ="principals";
    protected $fillable = [
      'principal_code',
      'name',
      'address',
      'country'
    ];

}
