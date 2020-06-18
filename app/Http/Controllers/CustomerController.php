<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\SMSMethod;
use Validator;
use App\AppSettings;
use App\Customer;
use App\Order;
use App\OrderDetail;
use App\RestaurantTable;
use DB;

class CustomerController extends Controller
{

    public function newCustomer(){
        $allCustomers = Customer::All();

        return response()->json([
            'allCustomers' => $allCustomers
        ]);
    }
    public function addCustomer(Request $request){

        Customer::create($request->all());
        return response()->json([
            'message' => 'Customer added'
        ]);
    }
    public function getReservedCustomer(){
       $reservedCustomers = DB::table('customers')->where('status','reserved')->get();

        return response()->json([
            'reservedcustomers' => $reservedCustomers
        ]);
    }
    public function setStatusPresent($custid){
        $customerRecord = Customer::find($custid);
        $customerRecord->status = "present";
        $customerRecord->save();

        return response()->json([
            'message' => 'Status updated to present'
        ]);
     }
     public function setStatusCancelled($custid){
        $customerRecord = Customer::find($custid);
        $customerRecord->status = "cancelled";
        $customerRecord->save();

        return response()->json([
            'message' => 'Status updated to cancelled'
        ]);
     }
     public function setNotified($custid){
         $customerRecord = Customer::find($custid);
         $customerRecord->status = "notified";
         $customerRecord->save();

         return response()->json([
            'message' => 'Status updated to notified'
         ]);
     }
     public function getNotified(){
         $notified = DB::table('customers')->where('status','notified')->get();

         return response()->json([
             'notified' => $notified
         ]);
     }
    public function requestBillOut($order_id){

        $orderid = Order::find($order_id);
        return response()->json([
            'orderid' => $orderid->order_id,
            'tableno'  => $orderid->tableno
            //'discount'  => $discount
            ]);
    }
    public function placeorder(Request $request){

        $data = $request->all();
        $finalArray = array();

        foreach($data as $key=>$value){
           
            array_push($finalArray,array(
                'order_id'=> $value['order_id'],
                'orderQty' => $value['orderQty'],
                'qtyToServe' => $value['qtyToServe'],
                'menuID' =>  $value['menuID'],
                'status' => $value['status'],
                'subtotal' => $value['subtotal'] 
            ));
        
        }
        OrderDetail::insert($finalArray);

        return response()->json([
            'message'=> 'Order successful!',
            'final' => $finalArray
        ]);
    }

    public function editOrder($order_id){
        $allMenus = Menu::all();
        $allOrders = OrderDetail::find($order_id);

        return response()->json([
            'allMenus' => $allMenus,
            'allOrders' => $allOrders
        ]);
    }

    public function getPhonenumber($custid){
        $c = DB::table('customers')->where('custid',$custid)->get();

        return response()->json([
            'phonenum' =>  $c
        ]);
    }
    public function callWaiter($tableno){
        $table = RestaurantTable::find($tableno);
        $table->concern = 1;
        $table->save();

        return response()->json([
            'message' => 'Your concern has been sent!'
        ]);
    }

}
