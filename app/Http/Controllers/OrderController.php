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

    public function getCustomerStatus($orderId){

        $status = Order::find($orderId)->where('status'.'billout')->get();

        return response()->json($status);
    }

    

}