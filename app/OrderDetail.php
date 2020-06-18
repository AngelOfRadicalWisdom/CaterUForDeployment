<?php

namespace App;
use App\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class OrderDetail extends Model
{
  use SoftDeletes;
  protected $table = 'order_details';
  protected $primaryKey = 'id';
  public $incrementing= true;
  public $timestamps = false;


  protected $fillable = array('id','order_id','orderQty','menuID','status','subtotal','qtyServed','created_at');
  public function menu(){
    return $this->hasMany('App\Menu','menuID','menuID');
  }
  public function order(){
    return $this->hasMany('App\Order','order_id','order_id');
}
// public function getSumQty($menuID){
//   return DB::table('order_details')->where('menuID',$menuID)->sum('orderQty');
// }
}//
