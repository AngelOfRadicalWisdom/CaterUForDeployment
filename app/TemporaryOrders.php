<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemporaryOrders extends Model
{
    protected $table = 'temporary-orders';
    protected $primaryKey = 'id';
    public $incrementing= true;
    public $timestamps = true;

    protected $fillable = ['tempId,id','order_id','menuID','status','orderQty','bundleid'];
}
