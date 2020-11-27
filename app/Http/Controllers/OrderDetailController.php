<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\OrderDetail;
use App\Category;
use App\SubCategory;
use App\Menu;
use App\Order;
use App\Kitchen;
use DB;

class OrderDetailController extends BaseController
{
 
    public function orderList($order_id){ 
        $bundles = array();
        $items = array();

    $orders = DB::table('orders')
    ->join('order_details','orders.order_id','=','order_details.order_id')
    -join('kitchenrecords','kitchenrecords.order_id','=','order.order_id')
    ->join('temporary_orders','temporary_orders.id','=','kitchenrecords.id')
    ->join('menus', 'order_details.menuID', '=', 'menus.menuID')
    
    // ->where('order_details.bundleid','=',null)
    ->where('orders.order_id',$order_id)
    ->get();
    
        //     $bundleItems = DB::table('order_details')
        //     ->select('order_details.qtyServed','order_details.orderQty as orderQty', 'menus.name as menuName','bundles.name as bundlename', 'bundle_details.qty','bundles.bundleid', 'bundles.price','order_details.id')
        //     ->join('bundles', 'order_details.bundleid', '=', 'bundles.bundleid')
        //     ->join('bundle_details','bundles.bundleid','=','bundle_details.bundleid')
        //     ->join('menus', 'menus.menuID','=','bundle_details.menuID')
        //     ->where('order_details.bundleid','!=',null)
        //     ->where('order_details.order_id',$order_id)
        //     ->get();

        // foreach($orders as $item){
        //     array_push($items, $item);
        // }
        // foreach($bundleItems as $item){
        //     array_push($items, $item);
        // }
        return response()->json([
            'data' => $items
        ]);
    }

    
    public function getTotal($order_id){
        $orderDetails = OrderDetail::where('order_id',$order_id)->get();
        $total = 0;
        foreach ($orderDetails as $order) {
            $total += $order->subtotal;
        }
        return response()->json([
            'total' => $total
        ]);
    }

    public function getAllServedMenus()
    {

        $allOrders = OrderDetail::all();
        $allCategories = Category::all();
        $drinks = array();
        $result = array();
        foreach ($allOrders as $orders) {
            foreach ($orders->order as $ords) {

                $order = Order::find($orders->order_id);
                $menus = Menu::find($orders->menuID);
                $menus->subCategory();
                $sub = SubCategory::find($menus->subcatid);
                $sub->category();
                $catid = $menus->subcategory->categoryid;


                if ($orders->status == 'served') {
                    array_push($drinks, array(
                        'order_id' => $order->order_id,
                        'tableno' => $order->tableno,
                        'name' => $menus->name,
                        'menu_id' => $menus->menuID,
                        'detail_id' => $orders->id,
                        'quantity' => $orders->orderQty,

                    ));
                }
            }
        }

        foreach ($drinks as $element => $value) {
            $result[$value['order_id']][] = $value;
        }
        return response()->json([

            'result' => $result
        ]);
    }
    public function cancelOrderMenu($id)
    {
        $orders = OrderDetail::find($id);
        $order = new OrderDetail;
        $order->status = "cancelled";

        $order->save();
        return response()->json([
            'message' => 'Order is cancelled'
        ]);
    }

    public function setServeQty(Request $request)
    {
        $records = OrderDetail::find($request->id);
        $records->qtyServed -= $request->noItemToServe;
        $records->save();

        return response()->json([
            'message' => $request->noItemToServe
        ]);
    }



    public function isServed($id)
    {
        $status = '';
        $servedQty = OrderDetail::whereId($id)->pluck('qtyServed')->first();
      

        if ($servedQty === 0) {
            $detail = OrderDetail::find($id);
            $detail->status = 'served';
            $detail->save();

            $status = 'Order is served.';
        } else {
            $status = 'Orders is being prepared.';
        }
        return response()->json([
            'status' => $status
        ]);
    }

    public function isServedBundle($id,Request $request){
        $status = Kitchen::find($id);
        $status->status = 'serving';
        $status->save();
        $bundle = Kitchen::find($request->id);
        $bundle->status = 'serving';
        $bundle->save();
        

        return response()->json([
            'message' => 'Status updated to for serving'
        ]);
    }

    public function isForServingBundles($id,Request $request)
    {
        $status = Kitchen::find($id);
        $status->status = 'serving';
        $status->save();
        $bundle = Kitchen::find($request->id);
        $bundle->status = 'serving';
        $bundle->save();
        

        return response()->json([
            'message' => 'Status updated to for serving'
        ]);
    }

}