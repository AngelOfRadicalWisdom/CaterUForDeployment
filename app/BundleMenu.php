<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BundleMenu extends Model
{
    use SoftDeletes;
    protected $table = 'bundle_menus';
    protected $primaryKey = 'bundleid';
    public $incrementing= false;
    public $timestamps = false;
    protected $fillable = array('bundleid','price','servingsize','name','details','image');
}
