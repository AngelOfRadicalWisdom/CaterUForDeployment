<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderDetail;
use App\Order;
use App\Menu;
use DB;
class CashierController extends Controller
{
    public function getbilldetail($tableno){
        $arr = array();
        $order_records = DB::table('order_details')
                        ->select('order_details.status as odStatus','order_details.id',
                        'menus.menuID','menus.name','orders.status','orders.order_id',
                        'orders.custid','orders.tableno','order_details.orderQty',
                        'order_details.subtotal','menus.price','orders.total')
                        ->join('orders','order_details.order_id','=','orders.order_id')
                        ->join('menus','menus.menuID','=','order_details.menuID')
                        ->where('orders.tableno',$tableno)
                        ->where('orders.status','billout')
                        ->get();
        
       array_push($arr, array(
           'records' => $order_records,
           'tableno' => $tableno
           
       ));

      return response()->json([
          'records' => $arr
         
         
        ]);
    }
    public function getreceiptdetail($order_id){
        $order_records = DB::table('order_details')
                        ->join('orders','order_details.order_id','=','orders.order_id')
                        ->join('menus','menus.menuID','=','order_details.menuID')
                        ->join('employees','orders.empid','=','employees.empid')
                        ->where('orders.status','paid')
                        ->where('orders.order_id',$order_id)
                        ->get();
       

      return response()->json([
          'records' => $order_records
         
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
         $orders = DB::table('orders')->where('status','billout')->get();

          return response()->json([
             'table' => $orders
          ]);
    }
    public function sendbill(Request $request){
        $bill = Order::find($request->order_id);
        $bill->status = $request->status;
        $bill->total = $request->total;
        $bill->save();

        return response()->json([
           'message' => "Bill sent"
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
