<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    public $incrementing = false;
    protected $fillable = ['id','image','name','f_name','b_date','gender','phone','local_add','per_add','email','password','remember_token','employee_id','dept_id','deg_id','date','salary','ac_name','ac_num','bank_name','code','pan_num',' branch','resume','offer_letter','join_letter','con_letter','proof'];
}
