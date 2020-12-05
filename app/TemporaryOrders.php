<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemporaryOrders extends Model
{
    protected $table = 'temporary_orders';
    protected $primaryKey = 'tempId';
    public $incrementing= true;
    public $timestamps = true;

    protected $fillable = ['tempId','id','order_id','menuID','bundleid','orderQty','qtyServed','status',];
}
