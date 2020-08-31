<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Kitchen extends Model
{
    use SoftDeletes;
    protected $table = 'kitchen';
    protected $primaryKey = 'id';    
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable =array('menuID','OrderQty','order_id','status');
}

class Kitchen extends Model
{
    protected $table = 'kitchenrecords';
    protected $primaryKey = 'id';
    public $incrementing= true;
    public $timestamps = true;

    protected $fillable = ['id','order_id','menuID','status','orderQty','bundleid'];
}

