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
    public function readyToServe(){
        $allOrders = OrderDetail::all();
        $allCategories = Category::all();
        $list=array();
        $result = array();
        foreach($allOrders as $orders){
            foreach($orders->order as $ords){

                $order = Order::find($orders->order_id);
                $menus = Menu::find($orders->menuID);
                $menus->subCategory();
                $sub = SubCategory::find($menus->subcatid);
                $sub->category();
                $catid = $menus->subcategory->categoryid;

                if($orders->status == 'Ready'){
                    array_push( $list,array(
                        'order_id' => $order->order_id,
                        'tableno'=> $order->tableno,
                        'name' => $menus->name,
                        'menu_id' => $menus->menuID,
                        'detail_id' => $orders->id,
                        'quantity' => $orders->orderQty,
                        'status' => $orders->status
                    ));

                }
            }
        }

        foreach ($list as $element=> $value) {
            $result[$value['order_id']][] = $value;
        }
        return response()->json([

            'result' => $result
        ]);
    }
    public function servedDrinkList(){
      $drinks = DB::table('order_details')
                    ->where('status','Served')
                    ->where('menuID','1001');
    }
    public function getCallNotification(){
        $concerns = DB::table('tables')->where('concern',1)->count();

        return response()->json([
            'message' => $concerns
        ]);
    }
    
}
