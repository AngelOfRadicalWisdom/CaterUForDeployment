<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Customer extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'custid';
    protected $table = 'customers';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = array('custid','name','phonenumber','status',"tableno");
    
    public function order(){
        return $this->belongsTo('App\Order','custid');
    }
}
