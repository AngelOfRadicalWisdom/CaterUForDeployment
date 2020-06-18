<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apriori extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    public $table = 'apriori';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = array('id','menuID','groupNumber');
}
