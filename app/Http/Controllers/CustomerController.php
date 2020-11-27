<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\SMSMethod;
use Validator;
use Carbon\Carbon;
use App\AppSettings;
use App\Customer;
use App\Order;
use App\OrderDetail;
use App\RestaurantTable;
use App\Kitchen;
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

    public function reserveNewCustomer(Request $request){
        $dt = Carbon::now();
        $today = $dt->toDateString();
        $result ='';
        $res = DB::table('customers')
        ->select('priorityNum','time_notified')
        ->get();

        if(count($res)!= 0){
            $data = $res->last();
            $dateFromDB=Carbon::parse($data->time_notified)->toDateString();
            if($dateFromDB == $dt->toDateString()){
                $newCustomer = new Customer();
                $newCustomer->phonenumber = $request->phoneNumber;
                $newCustomer->partysize= $request->partySize;
                $newCustomer->status = 'reserved';
                $newCustomer->name = $request->name;
                $newCustomer->priorityNum = $data->priorityNum + 1;
                $newCustomer->save();
           
            }else{
                $newCustomer = new Customer();
                $newCustomer->phonenumber = $request->phoneNumber;
                $newCustomer->partysize= $request->partySize;
                $newCustomer->status = 'reserved';
                $newCustomer->name = $request->name;
                $newCustomer->priorityNum = 1;
                $newCustomer->save();  
            }
            
        } else{
            $newCustomer = new Customer();
            $newCustomer->phonenumber = $request->phoneNumber;
            $newCustomer->partysize= $request->partySize;
            $newCustomer->status = 'reserved';
            $newCustomer->name = $request->name;
            $newCustomer->priorityNum = 1;
            $newCustomer->save();  
        }
        

        return response()->json([
            'message'=> "Reservation successful"
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
        $customerRecord->status = "reservationConfirmed";
        $customerRecord->save();

        return response()->json([
            'message' => 'Status updated to present'
        ]);
     }
     public function setStatusCancelled($custid){
        $customerRecord = Customer::find($custid);
        $customerRecord->status = "reservationCancelled";
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
     public function setConfirm($custid, Request $request){
        $customerRecord = Customer::find($custid);
        $customerRecord->status = "confirmed";
        $customerRecord->save();

        $table = RestaurantTable::find($request->tableNo);
        $table->status = 'Confirmed';
        $table->save();
       

         return response()->json([
           'message' => 'Updated successfully!'
        ]);
     }
     
     public function getNotified(){
         $notified = DB::table('customers')->where('status','notified')->get();

         return response()->json([
             'notified' => $notified
         ]);
     }

     public function deleteNotifiedCustomer($custid, Request $request){
        $customerRecord = Customer::find($custid);
        $customerRecord->status = "no show";
        $customerRecord->save();

        $table = RestaurantTable::find($request->tableNo);
        $table->status = 'Available';
        $table->save();

         return response()->json([
           'message' => 'Deleted successfully!'
        ]);
     }
    public function requestBillOut(Request $request, $order_id){

        $detail= Order::find($order_id);
        $detail->total = $request->total;
        $detail->status = 'billout';
        $detail->save();
        return response()->json([
            'message' => 'Billout success'
            ]);
    }
    public function placeorder(Request $request,$order_id){
        $data = $request->all();
        // $bundles = array();
        $finalArray = array();

        //    foreach($data as $value){
        //     foreach($value as $key){
        //     array_push($finalArray,array(
        //         'order_id' =>$key['order_id'],
        //         'orderQty' => $key['orderQty'],
        //         'qtyServed' =>$key['orderQty'],
        //         'menuID' =>  $key['menuID'],
        //         'bundleid' => $key['bundleid'],
        //         'status' => 'waiting',
        //         'subtotal' => $key['subtotal'] 
        //     ));
        // }
        //     }
            foreach($data as $val){
        foreach($val as $value){
            if($value['bundleid']!=null){
                $items = $this->getBarKitchenBundles($value['bundleid']);
               foreach($items as $item){
                   $kitchenorders = new Kitchen();
                   $kitchenorders->orderQty = $value['orderQty'];
                   $kitchenorders->menuID = $item->menuID;
                   $kitchenorders->bundleid = $item->bundleid;
                   $kitchenorders->order_id = $order_id;
                   $kitchenorders->status = 'waiting';
                   $kitchenorders->save();

                   
               }
            }else{
                $kitchenorders = new Kitchen();
                $kitchenorders->orderQty =  $value['orderQty'];
                $kitchenorders->menuID =$value['menuID'];
                $kitchenorders->bundleid = $value['bundleid'];
                $kitchenorders->order_id = $order_id;
                $kitchenorders->status = 'waiting';
                $kitchenorders->save();
            }
        }
            }

            foreach($kitchenorders as $value){
                $tempOrders = new TemporaryOrders();
                $tempOrders->id = $value['id'];
                $tempOrders->orderQty =  $value['orderQty'];
                $tempOrders->menuID =$value['menuID'];
                $tempOrders->bundleid = $value['bundleid'];
                $tempOrders->order_id = $order_id;
                $tempOrders->status = 'waiting';
                $tempOrders->save();
            }
        // OrderDetail::insert($finalArray);
       
        // DB::table('carts')->where('order_id',$order_id)->delete();

        $records = DB::table('kitcherecords')->get();
        foreach($records as $value){
            $tempOrders = new TemporaryOrders();
            $tempOrders->id = $value['id'];
            $tempOrders->orderQty =  $value['orderQty'];
            $tempOrders->menuID =$value['menuID'];
            $tempOrders->bundleid = $value['bundleid'];
            $tempOrders->order_id = $order_id;
            $tempOrders->status = 'waiting';
            $tempOrders->save();
        }
        return response()->json([
            'request' => $kitchenorders
        ]);
    }

    function getBarBundles($bundleid){
        $bar = DB::table('bundles')
                   ->join('bundle_details','bundle_details.bundleid','=','bundles.bundleid')
                   ->join('menus',"menus.menuID",'=','bundle_details.menuID')
                   ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
                   ->join('categories','categories.categoryid','=','sub_categories.categoryid')
                   ->where('categories.categoryname','=','Drinks')
                   ->where('bundles.bundleid',$bundleid)
                   ->get();

        return $bar;
    }
    function getBarKitchenBundles($bundleid){
        $kitchen = DB::table('bundles')
        ->select('bundles.name AS bundleName','menus.name AS itemName','menus.menuID','bundle_details.qty','bundles.bundleid as bundleid')
                   ->join('bundle_details','bundle_details.bundleid','=','bundles.bundleid')
                   ->join('menus',"menus.menuID",'=','bundle_details.menuID')
                   ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
                   ->join('categories','categories.categoryid','=','sub_categories.categoryid')
                   ->where('bundles.bundleid',$bundleid)
                   ->get();
        return $kitchen;
    }
    

    public function getPhonenumber($custid){
        $c = DB::table('customers')->where('custid',$custid)->get();

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