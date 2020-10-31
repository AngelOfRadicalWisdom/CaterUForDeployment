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
use App\Kitchen;
use DB;

class CustomerController extends Controller
{
    //mobile new customer
    public function newCustomer()
    {
        $allCustomers = Customer::All();

        return response()->json([
            'allCustomers' => $allCustomers
        ]);
    }
    //mobile saving the added customer
    public function addCustomer(Request $request)
    {

        Customer::create($request->all());
        return response()->json([
            'message' => 'Customer added'
        ]);
    }
    //mobile reserved customer
    public function reserveNewCustomer(Request $request)
    {
        $newCustomer = new Customer();
        $newCustomer->phonenumber = $request->phoneNumber;
        $newCustomer->partysize = $request->partySize;
        $newCustomer->status = 'reserved';
        $newCustomer->name = $request->name;
        $newCustomer->save();

        return response()->json([
            'message' => 'Customer reserved successfully!'
        ]);
    }
    //mobile retrieve Reserved Customer
    public function getReservedCustomer()
    {
        $reservedCustomers = DB::table('customers')->where('status', 'reserved')->get();

        return response()->json([
            'reservedcustomers' => $reservedCustomers
        ]);
    }
    //mobile set customer status to present
    public function setStatusPresent($custid)
    {
        $customerRecord = Customer::find($custid);
        $customerRecord->status = "reservationConfirmed";
        $customerRecord->save();

        return response()->json([
            'message' => 'Status updated to present'
        ]);
    }
    //mobile set customer status to cancelled
    public function setStatusCancelled($custid)
    {
        $customerRecord = Customer::find($custid);
        $customerRecord->status = "reservationCancelled";
        $customerRecord->save();

        return response()->json([
            'message' => 'Status updated to cancelled'
        ]);
    }
    //mobile notify customer
    public function setNotified($custid)
    {
        $customerRecord = Customer::find($custid);
        $customerRecord->status = "notified";
        $customerRecord->save();

        return response()->json([
            'message' => 'Status updated to notified'
        ]);
    }
    //mobile retrieve notifed customer
    public function getNotified()
    {
        $notified = DB::table('customers')->where('status', 'notified')->get();

        return response()->json([
            'notified' => $notified
        ]);
    }
    //mobile custmoer billout
    public function requestBillOut(Request $request, $order_id)
    {

        $detail = Order::find($order_id);
        $detail->total = $request->total;
        $detail->status = 'billout';
        $detail->save();
        return response()->json([
            'message' => 'Billout success'
        ]);
    }
    //mobile place order
    public function placeorder(Request $request, $order_id)
    {
        $data = $request->all();
        $finalArray = array();

        foreach($data as $value){
            foreach($value as $key){
                // array_push($finalArray, $value);
            // }
            array_push($finalArray,array(
                'order_id' =>$key['order_id'],
                'orderQty' => $key['orderQty'],
                'qtyServed' =>$key['orderQty'],
                'menuID' =>  $key['menuID'],
                'bundleid' => $key['bundleid'],
                'status' => 'waiting',
                'subtotal' => $key['subtotal'] 
            ));
        }
            }

    //         $val = '';
     foreach($data as $value){
            foreach($value as $key){
            //  for($i= 0; $i < $key["orderQty"]; $i++){
        $kitchenorders = new Kitchen();
        $kitchenorders->orderQty = $key['orderQty'];
        $kitchenorders->menuID = $key["menuID"];
        $kitchenorders->bundleid = $key["bundleid"];
        $kitchenorders->order_id = $order_id;
        $kitchenorders->status = 'waiting';
    
        $kitchenorders->save();
        // }
            }
        }
       

        OrderDetail::insert($finalArray);

        DB::table('carts')->where('order_id', $order_id)->delete();
        return response()->json([
            'finalArry' => $order_id,
            'request' => $data
        ]);
    }

    //mobile retrieve customer phone number
    public function getPhonenumber($custid)
    {
        $c = DB::table('customers')->where('custid', $custid)->get();

        return response()->json([
            'phonenum' =>  $c
        ]);
    }

    public function assignTable(Request $request, $custid){
        $newCustomer = Customer::find($custid);
        $newCustomer->tableno = $request->tableno;
        $newCustomer->status= 'notified';
        $newCustomer->save();

        $table = RestaurantTable::find($request->tableno);
        $table->status = 'Reserved';
        $table->save();

        return response()->json([
            'message' => $custid
        ]);
    }

}
