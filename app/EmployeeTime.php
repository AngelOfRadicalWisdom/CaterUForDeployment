<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTime extends Model
{
    //
    protected $table = 'employeetime';
    public $timestamps = false;
    protected $fillable =array('user_id','timein','timeout');
}
