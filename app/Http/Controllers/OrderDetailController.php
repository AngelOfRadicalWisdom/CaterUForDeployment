<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\OrderDetail;
use App\Category;
use App\SubCategory;
use App\Menu;
use App\Order;
use DB;
class OrderDetailController extends BaseController
{
 
    public function orderList($order_id){ 
       $orders = Order::find($order_id);
       $orderDetails = OrderDetail::all();
       $orderlist = array();
       foreach($orderDetails as $detail){
           foreach($detail->menu as $menu){
               if($detail->order_id == $orders->order_id){
                array_push($orderlist, array(
                    'tableno' => $orders->tableno,
                    'detail_id' => $detail->id,
                    'order_id' => $detail->order_id,
                    'orderQty' => $detail->orderQty,
                    'menuID' =>  $detail->menuID,
                    'status'    => $detail->status,
                    'menuName'=> $menu->name,
                    'subtotal' => $detail->subtotal,
                    'qtyServed'=> $detail->qtyServed
                ));
           }
        }
       }
        return response()->json([
            'list' => $orderlist
        ]);
    }
    public function getTotal($order_id){
        $orderDetails = OrderDetail::where('order_id',$order_id)->get();
        $total = 0;
        foreach($orderDetails as $order){
            $total += $order->subtotal; 
        }
        return response()->json([
            'total'=>$total
        ]);


    }

    public function getAllServedMenus(){

        $allOrders = OrderDetail::all();
        $allCategories = Category::all();
        $drinks=array();
        $result = array();
       foreach($allOrders as $orders){
           foreach($orders->order as $ords){

            $order = Order::find($orders->order_id);
            $menus = Menu::find($orders->menuID);
            $menus->subCategory();
            $sub = SubCategory::find($menus->subcatid);
            $sub->category();
            $catid = $menus->subcategory->categoryid;


            if($orders->status == 'served'){
                array_push( $drinks,array(
                    'order_id' => $order->order_id,
                    'tableno'=> $order->tableno,
                    'name' => $menus->name,
                    'menu_id' => $menus->menuID,
                    'detail_id' => $orders->id,
                    'quantity' => $orders->orderQty,
                  
                ));

            }
        }
        }

        foreach ($drinks as $element=> $value) {
            $result[$value['order_id']][] = $value;
        }
        return response()->json([

            'result' => $result
        ]);

    }
    public function cancelOrderMenu($id){
        $orders = OrderDetail::find($id);
        $order = new OrderDetail;
        $order->status = "cancelled";

        $order->save();
        return response()->json([
            'message' => 'Order is cancelled'
        ]);
    }

    // public function getOrderByID($order_id){

    //     $orders = DB::table('order_details')
    //     ->select('menus.name','menus.price'
    //     ,'orders.order_id','tableno','orders.total',
    //     'order_details.orderQty AS orderNum',
    //     'order_details.qtyToServe AS served',
    //     'order_details.subtotal AS subtotal',
    //     'order_details.status AS status',
    //     'order_details.id AS id')
    //     ->join('orders','orders.order_id','=','order_details.order_id') 
    //     ->join('menus','menus.menuID','=','order_details.menuID')
    //     ->where('orders.order_id',$order_id)
    //     ->where('order_details.status','waiting')->get();

    //      return response()->json([
    //          'orders' => $orders
    //      ]);

    // }
   
    public function setServeQty(Request $request){
        $records = OrderDetail::find($request->id);
        $records->qtyServed -= $request->noItemToServe;
        $records->save();

        return response()->json([
            'message'=> $request->noItemToServe
        ]);
      }
   
   
    
    public function isServed($id){
        $status = '';
        $servedQty = OrderDetail::whereId($id)->pluck('qtyServed')->first();
        if($servedQty === 0){
            $detail= OrderDetail::find($id);
            $detail->status = 'served';
            $detail->save();
            $status = 'Order is served.';
            
        }else{
            $status = 'Orders is being prepared.';
        }
        return response()->json([
            'status' => $status
        ]);
    }
  


}
