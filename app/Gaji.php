<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $table = 'gaji';

    public $incrementing = false;
    protected $fillable = ['id','bulan','tahun','gaji'];
}
