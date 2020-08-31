<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $table = 'carts';
    protected $primaryKey = 'id';
    public $incrementing= true;
    public $timestamps = false;

    protected $fillable = ['id','order_id','menuID','qty'];
}
