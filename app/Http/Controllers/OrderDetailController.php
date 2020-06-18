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
    public function allOrderList(){
        $allOrders = OrderDetail::all();
        $allOrd   = $allOrders->order();

        return response()->json([
            'detail' => $allOrders,
            'order' => $allOrd
        ]);
    }
    public function waitingOrderList($order_id){
       $orders = Order::find($order_id);
       $orderDetails = OrderDetail::all();
       $orderlist = array();
       foreach($orderDetails as $detail){
           foreach($detail->menu as $menu){
        //    if($detail->status == 'waiting' || $detail->status == 'served' && $detail->order_id == $orders->order_id){
            if($detail->order_id == $orders->order_id && $detail->status == 'waiting'){
                array_push($orderlist, array(
                    'tableno' => $orders->tableno,
                    'detail_id' => $detail->id,
                    'order_id' => $detail->order_id,
                    'orderQty' => $detail->orderQty,
                    'menuID' =>  $detail->menuID,
                    'status'    => $detail->status,
                    'menuName'=> $menu->name,
                    'subtotal' => $detail->subtotal,
                ));
           }
        }
       }
        return response()->json([
            'list' => $orderlist
        ]);
    }
    public function servedOrderList($order_id){
        $orders = Order::find($order_id);
        $orderDetails = OrderDetail::all();
        $orderlist = array();
        foreach($orderDetails as $detail){
            foreach($detail->menu as $menu){
         //    if($detail->status == 'waiting' || $detail->status == 'served' && $detail->order_id == $orders->order_id){
             if($detail->order_id == $orders->order_id && $detail->status == 'served'){
                 array_push($orderlist, array(
                     'tableno' => $orders->tableno,
                     'detail_id' => $detail->id,
                     'order_id' => $detail->order_id,
                     'orderQty' => $detail->orderQty,
                     'menuID' =>  $detail->menuID,
                     'status'    => $detail->status,
                     'menuName'=> $menu->name,
                     'subtotal' => $detail->subtotal,
                 ));
            }
         }
        }
         return response()->json([
             'list' => $orderlist
         ]);
     }

    public function readyOrderList(){
        $all=DB::table('order_details')
                ->where('status','Ready')
                ->get();
        return response()->json([
            'ready orders' => $all
        ]);
    }
    // public function placeorder(Request $request){

    //     $data = $request->all();
    //     $finalArray = array();

    //     foreach($data as $key=>$value){
    //         array_push($finalArray,array(
    //         'order_id' => $value['order_id'],
    //         'orderQty' => $value['orderQty'],
    //         'menuID' =>  $value['menuID'],
    //         'status' => $value['status'],
    //         'subtotal' => $value['subtotal'] ),
    //         );
    //     };
    //     OrderDetail::insert($finalArray);

    //     return response()->json([
    //         'message'=> 'Order successful!',
    //         'final' => $finalArray
    //     ]);
    // }
    public function editOrder($order_id){
        $allMenus = Menu::all();
        $allOrders = OrderDetail::find($order_id);

        return response()->json([
            'allMenus' => $allMenus,
            'allOrders' => $allOrders
        ]);
    }
    public function saveOrderUpdate($order_id, Request $request){
        $editOrder = OrderDetail::find($order_id);
        $editOrder->orderQty = $request->orderQty;
        $editOrder->save();

        return $this->response()->json([
            'message' => 'Order updated!'
        ]);
    }
    public function removeOrderItem($id){
        $removeOrder = OrderDetail::find($id);
        if($removeOrder){
            $removeOrder->delete();
        }
        return $this->response()->json([
           'message' => 'Item removed!'
        ]);
    }
    public function getServeMenuId(Request $request){
        $detailid = OrderDetail::find($request->id);

        return response()->json([
            'id' => $detailid
        ]);
    }
    public function serveMenu($id){
        $detail_status = OrderDetail::find($id);
        if($detail_status->status == 'Ready' && $detail_status != 'waiting'){
        $detail_status->status = 'served';
        $detail_status->save();

        return response()->json([
            'message' => 'Menu is served'
        ]);
        }
        else{
            return response()->json([
                'error_message' => 'Menu is not ready'
            ]);
        }

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
    public function orderStatusWaiting(){
        $waiting = DB::table('order_details')->where('status','waiting')->get();
        return response()->json([
            'orderWaitingList' => $waiting
        ]);
    }

    public function orderStatusServed(){
        $served = DB::table('order_details')->where('status','served')->get();

        return response()->json([
            'orderServedList' => $served
        ]);
    }
    public function orderStatusPreparing(){
        $preparing = DB::table('order_details')->where('status','preparing')->get();
        return response()->json([
            'orderPreparingList' => $preparing
        ]);
    }
    public function getAllOrders(){
        $allOrders = Order::all();

        return response()->json([
            'allOrders' => $allOrders
        ]);
    }

    public function getOrderByID($order_id){

        $orders = DB::table('order_details')
        ->select('menus.name','menus.price'
        ,'orders.order_id','tableno','orders.total',
        'order_details.orderQty AS orderNum',
        'order_details.qtyToServe AS served',
        'order_details.subtotal AS subtotal',
        'order_details.status AS status',
        'order_details.id AS id')
        ->join('orders','orders.order_id','=','order_details.order_id') 
        ->join('menus','menus.menuID','=','order_details.menuID')
        ->where('orders.order_id',$order_id)
        ->where('order_details.status','waiting')->get();

         return response()->json([
             'orders' => $orders
         ]);

    }
    public function getServedOrderByID($order_id){

        $orders = DB::table('order_details')
        ->select('menus.name','menus.price'
        ,'orders.order_id','tableno','orders.total',
        'order_details.orderQty AS orderNum',
        'order_details.qtyToServe AS served',
        'order_details.subtotal AS subtotal',
        'order_details.status AS status',
        'order_details.id AS id')
        ->join('orders','orders.order_id','=','order_details.order_id') 
        ->join('menus','menus.menuID','=','order_details.menuID')
        ->where('orders.order_id',$order_id)
        ->where('order_details.status','served')->get();

         return response()->json([
             'orders' => $orders
         ]);

    }
    public function getServeQty($id){
      //  $id = OrderDetail::find($id);
      $qty =DB::table('order_details')
            ->select('qtyServed')
            ->where('id',$id)->get(); 
    

        return response()->json([
            'quantity'=> $qty
        ]);
    }
    public function setServeQty(Request $request){
        $records = OrderDetail::find($request->id);
        $records->qtyToServe -= $request->serveItem;
        $records->save();

        return response()->json([
            'message'=> $request->serveItem
        ]);
      }
      public function checkQty($id){
        $isServed = false;
        $data = DB::table('order_details')->where('id',$id)->get();

        foreach($data as $result){
            if($result->qtyToServe === 0 ){
                DB::table('order_details')
                ->where('id',$id)
                ->update(['status' => 'served']);
                $isServed = true;
            }
       }

       return response()->json([
           'status' => $isServed
       ]);
      }
    
    public function changeOrderStatusToServing($id){ // customer
        $orderItem = Kitchen::find($id);
        $orderItem->status = 'serving';
        $orderItem->save();

        return response()->json([
            'message' => 'Order status is serving'
        ]);

    }

    public function changeOrderStatusToServed(Request $request){ // customer
        $items = DB::table('kitchenrecords')
        ->select(DB::raw('count(*) as menu_count, menuID'))
        ->where('order_id',$request->order_id)
        ->groupBy('menuID')
        ->get();

       foreach($items as $item){

           if($item->menuID === $request->menuID && $item->menu_count === 0){
            
            $orderItem = Menu::find($request->id);
            $orderItem->status = 'served';
            $orderItem->save();
            
           } else {
           continue;
           }
       }
    
        return response()->json([
            'items'=> $menu_orders
        ]);
      

    }
    public function getAllServingMenus(){
        $allOrders = OrderDetail::all();
        $allCategories = Category::all();
        $serving=array();
        $result = array();
       foreach($allOrders as $orders){
           foreach($orders->order as $ords){
              // foreach($allCategories as $category){

            $order = Order::find($orders->order_id);
            $menus = Menu::find($orders->menuID);
            $menus->subCategory();
            $sub = SubCategory::find($menus->subcatid);
            $cat = $sub->category();
            $catid = $menus->subcategory->categoryid;

            if($orders->status == 'serving' || $orders->status == 'served'){
                array_push( $serving,array(
                    'id' => $orders->id,
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
      //  }
        }

        // foreach ($drinks as $element=> $value) {
        //     $result[$value['order_id']][] = $value;
        // }
        return response()->json([

            'result' => $serving
        ]);
    }

    public function changeStatusToPrepare($id){
        $detail= Kitchen::find($id);
        $detail->status= 'preparing';
        $detail->save();

        return response()->json([
            'message' => 'Status changed to prepare'
        ]);
    }
    public function changeStatusToFinish($od_id){
        $detail= OrderDetail::find($od_id);
        $detail->status= 'done';
        $detail->save();

        return response()->json([
            'message' => 'Status changed to finish'
        ]);
    }
    public function changeOrderStatus(Request $request){ // customer

        $message = '';
        $orderItem = OrderDetail::find($request->id);
        if($orderItem->status == 'waiting' || $orderItem->status == 'preparing' ){
            $orderItem->status = $request->status;
            $orderItem->save();
            $message = 'Status successfully changed';
        } else {
            $message = 'Food is not ready';
        }
        return response()->json([
            'message' => $message
        ]);

    }
    public function getOrderQty($id){
        $items = DB::table('order_details')->select('menuID','orderQty')->where('id',$id)->get();

        return response()->json([
            'items' => $items
        ]);
    }
    public function isServed($id){
        $items = DB::table('order_details')->select('status')->where('id',$id)->get();
        $status = false;
        foreach($items as $item){
            if($item->status === 'served'){
                $status= true;
            }
        }
        return response()->json([
            'status' => $status
        ]);
    }
  


}
