<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Menu extends Model
{
    use SoftDeletes;
    protected $table = 'kitchen';
    protected $primaryKey = 'id';    
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable =array('menuID','OrderQty','order_id','status');
}
