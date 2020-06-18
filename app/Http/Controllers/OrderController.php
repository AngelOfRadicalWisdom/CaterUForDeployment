<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use App\Http\Controllers\BaseController as BaseController;
use App\OrderDetail;
use App\Order;
use App\Menu;
use App\RestaurantTable;
use App\Customer;
use DB;
class OrderController extends BaseController
{
    public function newOrder($id){
        $allOrders = OrderDetail::find($id);
        $allMenus = Menu::all();
        $allSubCategories = SubCategory::all();
        $allCategories = Category::all();

        return response()->json([
            'allOrders' =>  $allOrders,
            'allMenus'  =>  $allMenus,
            'allSubCategories'  =>  $allSubCategories,
            'allCategories' => $allCategories
        ]);
    }

    public function startOrder(Request $request){

        // $table =RestaurantTable::where('tableno',$request->tableno)->get();
        //         ->update(['status'=>'Occupied']);
        $table = RestaurantTable::find(1);
        if($table->status == 'Occupied'){
            return response()->json([
                'message' => 'Sorry, the table you selected is Occupied'
            ]);
        }else{

       $table->status = 'Occupied';
       $table->save();

        $newCustomer = Customer::create(['name'=>'cash']);
        $newOrder = new Order;
        $newOrder->custid= $newCustomer->custid;
        $newOrder->username=$request->username;
        $newOrder->tableno = $table->tableno;
        $newOrder->status = 'ordering';
        $newOrder->total = 0;
        $newOrder->save();

        return response()->json([
            'message' => 'Welcome, happy eating!',
            'order_id' =>  $newOrder->order_id
        ]);
       }
}

    public function paidOrder(){
        $menus = Menu::all();
        $details = OrderDetail::whereDate('date_ordered', '>=', Carbon::today()->toDateString());

        $paidOrders= Order::where('status','Paid')->get();
       // return view('admin.report.orderlist', compact('paidOrders','menus','details'));

       return response()->json([
           'details' => $details
       ]);
    }

    public function confirmPayment(Request $request){
        $orderItem = Order::find($request->order_id);
        $orderItem->status = 'billout';
        $orderItem->save();
        return response()->json([
            'message' => 'Bill out confirmed'
        ]);
    }

    public function successfulTransaction(){
        $details = OrderDetail::whereDate('date_ordered', '>=', Carbon::today()->toDateString());

        $paidOrders= Order::where('status','Paid')->get();
        return view('admin.report.sales', compact('paidOrders','details'));

    }
    public function getLatestOrderID($tableno){
        $order;
        $orderid = DB::table('orders')->select('order_id')
                    ->where('tableno', $tableno)->get();

        foreach($orderid as $od){
            if($od->status != 'billout'){
                $order = $od->order_id;
            }
        }

        return response()->json([
            'orderid' => $order
        ]);
    }

}
