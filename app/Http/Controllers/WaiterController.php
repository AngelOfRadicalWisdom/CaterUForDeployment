<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderDetail;
use App\Menu;
use App\Category;
use App\SubCategory;
use App\Order;
use DB;
class WaiterController extends Controller
{
    public function drinklist(){
        $drinks = DB::table('kitchenrecords')
        ->join('orders','orders.order_id','=','kitchenrecords.order_id')
        ->join('menus','menus.menuID','=','kitchenrecords.menuID')
        ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
        ->join('categories','sub_categories.categoryid','=','categories.categoryid')
       ->where('categories.name','=',"Drinks")
        ->where('kitchenrecords.status','!=','for serving')
       ->where('kitchenrecords.status','!=','serving')
       ->where('kitchenrecords.status','!=','served')
 
        ->orderBy('kitchenrecords.created_at','asc')->get();
 
         return response()->json([
             'orders' => $drinks
         ]);
     
    }    
}
