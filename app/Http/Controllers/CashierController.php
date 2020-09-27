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
    //     $order_records = DB::table('order_details')
    //                     ->select('order_details.status as odStatus','order_details.id',
    //                     'menus.menuID','menus.name','orders.order_id','orders.tableno',
    //                     'orders.custid','orders.tableno','order_details.orderQty',
    //                     'order_details.subtotal','menus.price','orders.status as stats','orders.total')
    //                     ->join('orders','order_details.order_id','=','orders.order_id')
    //                     ->join('menus','menus.menuID','=','order_details.menuID')
    //                     ->where('orders.tableno',$tableno)
    //                     ->get();

    //   return response()->json([
    //       'records' => $order_records
    //     ]);
    $bundles = array();
    $items = array();
       $orders = DB::table('order_details')
       ->join('menus', 'order_details.menuID', '=', 'menus.menuID')
       ->join('orders','order_details.order_id','=','orders.order_id')
       ->select('order_details.*','menus.name','menus.price')
       ->where('orders.status','=','billout')
       ->where('order_details.order_id',$order_id)
       ->get();
       
               $bundleItems = DB::table('order_details')
            //    ->select('order_details.qtyServed','order_details.orderQty as orderQty','bundles.name as name',  'bundles.price','order_details.id')
               ->join('bundles', 'order_details.bundleid', '=', 'bundles.bundleid')
            //    ->join('bundle_details','bundles.bundleid','=','bundle_details.bundleid')
               ->join('orders','order_details.order_id','=','orders.order_id')
            //    ->join('menus', 'menus.menuID','=','bundle_details.menuID')
               ->where('order_details.bundleid','!=',null)
               ->where('orders.status','=','billout')
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

    public function getBillOutList(){
         $orders = DB::table('orders')->where('status','billout')
         ->join('employees','orders.empid','=','employees.empid')
         ->get();

          return response()->json([
             'table' => $orders
          ]);
    }
    
    public function getTotal($orderid){
        $total = DB::table('order_details')
                ->where('order_id',$orderid)
                ->sum('subtotal');
        return response()->json([
            "total" => $total
        ]);
    }

}
