<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BundleDetails extends Model
{
    //
    use SoftDeletes;
    protected $table = 'bundle_details';
    protected $primaryKey = 'bundle_details_id';
    public $incrementing=true;
    public $timestamps = false;
    protected $fillable = array('bundle_details_id','menuID','name','description','price','servingsize','bundleid');
}
