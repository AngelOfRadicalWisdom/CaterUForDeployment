<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RestaurantTable extends Model
{
    use SoftDeletes;
    protected $table = 'tables';
    protected $primaryKey = 'tableno';
    public $timestamps = false;
    public $incrementing = true;

    public function customer(){
        return $this->belongsTo('App\Customer','tableno');
    }
    public function order(){
        return $this->belongsTo('App\Order','tableno');
    }

}
