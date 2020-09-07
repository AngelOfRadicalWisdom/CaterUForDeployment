<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderDetail;
use App\Order;
use App\Menu;
use DB;

class CashierController extends Controller
{
    //mobile get billdetail
    public function getbilldetail($tableno)
    {
        $order_records = DB::table('order_details')
            ->select(
                'order_details.status as odStatus',
                'order_details.id',
                'menus.menuID',
                'menus.name',
                'orders.order_id',
                'orders.tableno',
                'orders.custid',
                'orders.tableno',
                'order_details.orderQty',
                'order_details.subtotal',
                'menus.price',
                'orders.status as stats',
                'orders.total'
            )
            ->join('orders', 'order_details.order_id', '=', 'orders.order_id')
            ->join('menus', 'menus.menuID', '=', 'order_details.menuID')
            ->where('orders.tableno', $tableno)
            ->get();

        return response()->json([
            'records' => $order_records
        ]);
    }
    //mobile update the total
    public function updateTotal($order_id, Request $request)
    {

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
