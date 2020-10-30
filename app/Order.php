<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $incrementing= true;
    public $timestamps = false;

   protected $fillable= ['order_id','custid','empid','tableno','total','date_ordered'];
    public function orderDetail(){
        return $this->belongsTo('App\OrderDetail','order_id','order_id');
    }

    public function table(){
        return $this->hasOne('App\Table','tableno','tableno');
    }
    public function customer(){
        return $this->hasOne('App\Customer','custid','custid');
    }
    // public function menu(){
    //     return $this->
    // }
}
