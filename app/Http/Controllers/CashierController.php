<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderDetail;
use App\Order;
use App\Menu;
use DB;

class CashierController extends Controller
{
    public function getbilldetail($order_id){
    $bundles = array();
    $items = array();
       $orders = DB::table('order_details')
       ->join('menus', 'order_details.menuID', '=', 'menus.menuID')
       ->join('orders','order_details.order_id','=','orders.order_id')
       ->select('order_details.*','menus.name','menus.price','orders.total', 'orders.cashTender', 'orders.change')
       ->where('order_details.bundleid','=',null)
       ->where('order_details.order_id',$order_id)
       ->get();
       
               $bundleItems = DB::table('order_details')
               ->select('order_details.qtyServed','order_details.orderQty as orderQty', 'menus.name as menuName',
               'bundles.name as bundlename', 'bundle_details.qty','bundles.bundleid', 'bundles.price','order_details.id','order_details.subtotal as bundle_subtotal')
               ->join('bundles', 'order_details.bundleid', '=', 'bundles.bundleid')
               ->join('orders','order_details.order_id','=','orders.order_id')
               ->join('bundle_details','bundles.bundleid','=','bundle_details.bundleid')
               ->join('menus', 'menus.menuID','=','bundle_details.menuID')
               ->where('order_details.bundleid','!=',null)
               ->where('order_details.order_id',$order_id)
               ->get();
   
           foreach($orders as $item){
               array_push($items, $item);
           }
           foreach($bundleItems as $item){
               array_push($items, $item);
           }
           return response()->json([
               'data' => $items
           ]);
}
 
    public function updateTotal($order_id,Request $request){

        $orders = Order::find($order_id);
        $orders->total = $request->total;
        $orders->save();

        return response()->json([
            'message' => 'Bill sent'
        ]);
    }
    //mobile billout list
    public function getBillOutList()
    {
        $orders = DB::table('orders')->where('status', 'billout')
            ->join('employees', 'orders.empid', '=', 'employees.empid')
            ->get();

        return response()->json([
            'table' => $orders
        ]);
    }
    //mobile get total
    public function getTotal($orderid)
    {
        $total = DB::table('order_details')
            ->where('order_id', $orderid)
            ->sum('subtotal');
        return response()->json([
            "total" => $total
        ]);
    }
}