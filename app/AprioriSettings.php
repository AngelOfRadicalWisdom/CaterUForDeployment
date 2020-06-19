<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AprioriSettings extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'aprioriSettings';
    public $incrementing= true;
    public $timestamps = false;
    protected $fillable = array('id','support','confidence');
}
