<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    protected $table = 'kitchenrecords';
    protected $primaryKey = 'id';
    public $incrementing= true;
    public $timestamps = true;

    protected $fillable = ['id','order_id','menuID','status','orderQty','bundleid'];
}

