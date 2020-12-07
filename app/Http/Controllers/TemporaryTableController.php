<?php

namespace App\Http\Controllers;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Cart;
use App\Kitchen;
use App\TemporaryOrders;
use App\OrderDetail;
use DB;

class TemporaryTableController extends Controller
{
    public function saveCart(Request $request)
    {
        $cartitems = new Cart();

        $cartitems->order_id = $request->order_id;
        $cartitems->menuID = $request->menuID;
        $cartitems->qty = $request->qty;
        $cartitems->bundleid = $request->bundleid;
        $cartitems->save();

        return response()->json([
            'message' => "Added to cart",
        ]);
    }
    public function removeItembyId($id)
    {
        $items = DB::table('carts')->where('id', $id)->delete();

        return response()->json([
            'message' => 'Item successfully deleted!'

        ]);
    }
    public function getCartItems($order_id){
        $items = array();
        $menuItems = DB::table('carts')
            ->join('menus', 'carts.menuID', '=', 'menus.menuID')
            ->select('carts.*','menus.name','menus.price')
            ->where('carts.bundleid','=',null)
            ->where('carts.order_id',$order_id)
            ->get();

            $bundleItems = DB::table('carts')
            ->join('bundles', 'carts.bundleid', '=', 'bundles.bundleid')
            ->where('carts.order_id',$order_id)
            ->get();
        foreach($menuItems as $item){
            array_push($items, $item);
        }
        foreach($bundleItems as $item){
            array_push($items, $item);
        }

        return response()->json([
            'data' => $items
        ]);
    }
    public function updateQty($id, Request $request)
    {
        $detail = Cart::find($request->id);
        $detail->qty = $request->qty;
        $detail->save();

        return response()->json([
            'message' => 'Quantity updated!'
        ]);
    }
    
    
    public function getDrinkWaitingOrders()
    {
        $orders = DB::table('kitchenrecords')
            ->join('orders', 'orders.order_id', '=', 'kitchenrecords.order_id')
            ->join('menus', 'menus.menuID', '=', 'kitchenrecords.menuID')
            ->join('sub_categories', 'menus.subcatid', '=', 'sub_categories.subcatid')
            ->join('categories', 'sub_categories.categoryid', '=', 'categories.categoryid')
            ->where('categories.categoryname', '=', 'Drinks')
            ->where('kitchenrecords.status', '=', 'waiting')
            ->orderBy('kitchenrecords.created_at', 'asc')->get();

        return response()->json([
            'orders' => $orders
        ]);
    }
    public function getDrinkPrepareOrders()
    {
        $orders = DB::table('kitchenrecords')
            ->join('orders', 'orders.order_id', '=', 'kitchenrecords.order_id')
            ->join('menus', 'menus.menuID', '=', 'kitchenrecords.menuID')
            ->join('sub_categories', 'menus.subcatid', '=', 'sub_categories.subcatid')
            ->join('categories', 'sub_categories.categoryid', '=', 'categories.categoryid')
            ->where('categories.categoryname', '=', 'Drinks')
            ->where('kitchenrecords.status', '=', 'preparing')
            ->orderBy('kitchenrecords.created_at', 'asc')->get();

        return response()->json([
            'orders' => $orders
        ]);
    }
    public function removeFromKitchenOrders($id)
    {
        $orderid = DB::table('kitchenrecords')->where('id', $id)->delete();

        return response()->json([
            'message' => 'Successfully deleted!'
            // 'message' => $request
        ]);
    }

    public function isServed($id)
    {
        $status = Kitchen::find($id);
        $status->status = 'served';
        $status->save();

        return response()->json([
            'message' => 'status updated'
        ]);
    }
    // public function temporaryTableServed($tempId,Request $){
    //     $status = TemporaryOrders::find($tempId)->get();
    //     return response()->json([
    //         'message' => 'status updated'
    //     ]);
    // }

    public function isForServing($id)
    {
        $status = Kitchen::find($id);
        $status->status = 'served';
        $status->save();

        return response()->json([
            'message' => 'Status updated to served'
        ]);
    }

    public function isForServingBundles($id,Request $request)
    {
        $status = Kitchen::find($id);
        $status->status = 'served';
        $status->save();
        $bundle = Kitchen::find($request->id);
        $bundle->status = 'served';
        $bundle->save();
        

        return response()->json([
            'message' => 'Status updated to served'
        ]);
    }

    public function isReady($id)
    {
        $message = '';
        $status = Kitchen::find($id);
        if($status){
            $status->status = 'ready';
            $status->save();

            $tempStatus = DB::table('temporary_orders')
            ->where('id',$id)
            ->update(['status' => 'ready']);
            $message = "Status udpated";
        }else $message ="Could not find item";

        return response()->json([
            'message' => $message
        ]);
    }
    public function prepare($id)
    {
        $message = '';
        $status = Kitchen::find($id);
        if($status){
            $status->status = 'preparing';
            $status->save();

            $tempOrders = DB::table('temporary_orders')
            ->where('id',$id)
            ->update(['status'=>'preparing']);

            $message = 'Status updated!';
        }else $message = "Could not find item";

        return response()->json([
            'message' => $message
        ]);
    }
  
    public function requestCancelOrderItem($id){ 
        $orders = DB::table('order_details')
        ->where('id',$id)
        ->update(['status'=>'pendingcancel']);

        $tempData = DB::table('temporary_orders')->where('order_details_id',$id)->update(['status'=>'pendingcancel']);

        return response()->json(
            [
                'message'=> 'Order item cancellation is being processed!'
            ]
        );
    }
    public function getItemForCancel(){
        $orders = DB::table('temporary_orders')
        ->select('orders.tableno')
        ->join('orders','orders.order_id','=','temporary_orders.order_id')
        ->where('temporary_orders.status','pendingcancel')->get();

        return response()->json([
            'tablenos'=>$orders,
            'reason'=>'Order item cancellation'
        ]);
    }

   
    public function abortCancelItem($tempId){
        TemporaryOrders::where('tempId',$tempId)
        ->update(['status'=> 'waiting']);

        return response()->json([
            'message'=> 'Cancellation aborted!'
        ]);
    }
    public function isPreparing($id)
    {
        $preparing = false;
        $status = DB::table('kitchenrecords')
            ->where('id', $id)
            ->where('status', '=', 'preparing')
            ->count();
        if ($status === 1) {
            $preparing = true;
        }
        return response()->json([
            'status' => $preparing
        ]);
    }
    public function getAllPreparedItems(){

        $arr = array();
        $orders = DB::table('kitchenrecords')
        ->join('orders','orders.order_id','=','kitchenrecords.order_id')
        ->join('menus','menus.menuID','=','kitchenrecords.menuID')
        ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
        ->join('categories','sub_categories.categoryid','=','categories.categoryid')
        ->join('bundles','bundles.bundleid','=','kitchenrecords.bundleid')
        ->where('categories.categoryname','!=', 'Drinks')
        ->where('kitchenrecords.status','=','preparing')
        ->orderBy('kitchenrecords.updated_at','asc')->get();

        $bundles = DB::table('kitchenrecords')
        ->join('bundles','bundles.bundleid','=','kitchenrecords.bundleid')
        ->where('kitchenrecords.bundleid','!=',null)
        ->get();

        array_push($arr, $orders);
        array_push($arr,$bundles);
    
        return response()->json([
            'orders' => $arr
        ]);
    }

    public function servingStatusByTableNo($tableno)
    {

        $orders = DB::table('kitchenrecords')
            ->select('menus.name', 'kitchenrecords.status', 'kitchenrecords.orderQty', 'kitchenrecords.id', 'orders.tableno')
            ->join('orders', 'orders.order_id', '=', 'kitchenrecords.order_id')
            ->join('menus', 'menus.menuID', '=', 'kitchenrecords.menuID')
            ->join('sub_categories', 'menus.subcatid', '=', 'sub_categories.subcatid')
            ->join('categories', 'sub_categories.categoryid', '=', 'categories.categoryid')
            ->where('tableno', $tableno)
            ->orderBy('kitchenrecords.created_at', 'asc')->get();

        return response()->json([
            'orders' => $orders
        ]);
    }

    public function checkForReadyOrders(){
        $arr = array();
        $menus = DB::table('kitchenrecords')
        ->select('kitchenrecords.*','orders.tableno','orders.order_id','menus.name')
        ->join('orders','orders.order_id','=','kitchenrecords.order_id')
        ->join('menus','kitchenrecords.menuID','=','menus.menuID')
        ->where('kitchenrecords.bundleid',null)
        ->get();

         $orders = DB::table('kitchenrecords')
        ->select('kitchenrecords.*','menus.name as menuname','bundles.name as bundleName','orders.tableno')
        ->join('orders','orders.order_id','=','kitchenrecords.order_id')
        ->join('bundles','bundles.bundleid','=','kitchenrecords.bundleid')
        ->join('bundle_details','bundle_details.bundleid','=','bundles.bundleid')
        ->join('menus','bundle_details.menuID','=','menus.menuID')
        ->get();

        foreach($menus as $menu){
            array_push($arr,$menu);
        }
        foreach($orders as $order ){
            array_push($arr,$order);
        }
    
        $collection = new Collection($arr);
        $grouped = $collection->groupBy('tableno');
         return response()->json([
            'readyorders'=>$grouped
         ]);
    }
    public function getAllCompleteList(){
        $list = array();
        $orders = DB::table('kitchenrecords')
        ->select('orders.date_ordered', 'menus.name','kitchenrecords.id')
        ->join('orders','orders.order_id','=','kitchenrecords.order_id')
        ->join('menus','menus.menuID','=','kitchenrecords.menuID')
        ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
        ->join('categories','sub_categories.categoryid','=','categories.categoryid')
        ->where('categories.categoryname','!=', 'Drinks')
        ->where('kitchenrecords.status','=','ready')
        ->orderBy('kitchenrecords.updated_at','desc')->get();

        foreach($orders as $order){
            array_push($list,array(
                'date_ordered' => $order->date_ordered,
                'name'=> $list->name,
                'id'=> $list->id
            ));
        }
        return response()->json([
            'orders' => $list
        ]);
    }
    public function getAllCompleteDrinks(){
       
        $orders = DB::table('kitchenrecords')
        ->join('orders', 'orders.order_id', '=', 'kitchenrecords.order_id')
        ->join('menus', 'menus.menuID', '=', 'kitchenrecords.menuID')
        ->join('sub_categories', 'menus.subcatid', '=', 'sub_categories.subcatid')
        ->join('categories', 'sub_categories.categoryid', '=', 'categories.categoryid')
      // ->selectRaw("TIME(kitchenrecords.updated_at) as time_updated,menus.menuID")
        ->selectRaw("kitchenrecords.id,kitchenrecords.order_id,kitchenrecords.menuID,kitchenrecords.bundleid,kitchenrecords.orderQty,
        orders.status,TIME(kitchenrecords.created_at) as created_at, TIME(orders.updated_at) as updated_at,orders.custid,orders.empid,orders.tableno,orders.discountType,orders.discount,orders.discountedTotal,orders.total,orders.vatExemptRate,orders.total,orders.VATableSales,orders.cashTender,orders.change, orders.date_ordered,orders.deleted_at,
        menus.name,menus.details,menus.price,menus.servingsize,menus.image,
        sub_categories.subcatid,sub_categories.subname,
        categories.categoryid,categories.categoryname,categories.description")
        ->where('categories.categoryname', '=', 'Drinks')
        ->where('kitchenrecords.status', '=', 'ready')
        ->orderBy('kitchenrecords.updated_at', 'desc')->get();
        return response()->json([
            'orders' => $orders
        ]);
    }

    public function getKitchenOrders($status){
        $orders = DB::table('kitchenrecords')
        ->select(
            'kitchenrecords.status as kitchenStatus',
            'kitchenrecords.id',
            'orders.tableno',
            'kitchenrecords.created_at',
            'orders.order_id',
            'kitchenrecords.orderQty',
            'kitchenrecords.bundleid',
            'kitchenrecords.menuID'
        )
        ->join('orders', 'orders.order_id','=','kitchenrecords.order_id')
        ->where('kitchenrecords.status',$status)
        ->get();
        $bundles = [];
        foreach($orders as $order){
           
            if( $order->bundleid != null){
                $bundleItems = $this->getMealBundles($order->bundleid);
                    foreach($bundleItems as $item){
                        if($item->menuID == $order->menuID){
                        array_push($bundles,array(
                            'kitchen_id'=> $order->id,
                            'tableno'=>$order->tableno,
                            'date_ordered' =>$order->created_at,
                            'order_id'=> $order->order_id,
                            'status'=> $order->kitchenStatus,
                            'ordered'=> $order->orderQty,
                            'details'=> array(
                                [
                                    'bundleName'=> $item->bundleName,
                                    'qty'=>  $item->qty,
                                    'menuID'=>  $item->menuID,
                                    'itemName'=>  $item->itemName
                                    ]
                            )
                        )
                    );
                    }
                }
                         
                
            }else {
                $singles = $this->getMealSingle($order->menuID);
                foreach($singles as $single){
                    if($single != null ){
                    array_push($bundles,array(
                        'kitchen_id'=> $order->id,
                        'tableno'=>$order->tableno,
                        'date_ordered' =>$order->created_at,
                        'order_id'=> $order->order_id,
                        'status'=> $order->kitchenStatus,
                        'ordered'=> $order->orderQty,
                        'details'=>array(
                            ['bundleName'=> null,
                            'qty'=> null,
                            'menuID'=> $single->menuID,
                            'itemName'=> $single->itemName]
                        ))); 
                    }
                }
             
               
            }
            
        }

        return response()->json([
            'details' =>$bundles
        ]);
    }

    function getMealBundles($bundleid){
        $kitchen = DB::table('bundles')
        ->select('bundles.name AS bundleName','menus.name AS itemName','menus.menuID','bundle_details.qty','bundles.bundleid as bundleid')
                   ->join('bundle_details','bundle_details.bundleid','=','bundles.bundleid')
                   ->join('menus',"menus.menuID",'=','bundle_details.menuID')
                   ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
                   ->join('categories','categories.categoryid','=','sub_categories.categoryid')
                   ->where('categories.categoryname','!=','Drinks')
                   ->where('bundles.bundleid',$bundleid)
                   ->get();
        return $kitchen;
    }

    function getMealSingle($menuid){
                   return DB::table('menus')
                    ->select('menus.name AS itemName','menus.menuID')
                    ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
                    ->join('categories','categories.categoryid','=','sub_categories.categoryid')
                    ->where('categories.categoryname','!=','Drinks')
                    ->where('menus.menuID',$menuid)
                    ->get();
        
    }
    public function getBarOrders($status){
  
        $orders = DB::table('kitchenrecords')
        ->select(
            'kitchenrecords.status as kitchenStatus',
            'kitchenrecords.id',
            'orders.tableno',
            'kitchenrecords.created_at',
            'orders.order_id',
            'kitchenrecords.orderQty',
            'kitchenrecords.bundleid',
            'kitchenrecords.menuID'
        )
        ->join('orders', 'orders.order_id','=','kitchenrecords.order_id')
        ->where('kitchenrecords.status',$status)
        ->get();
        $bundles = [];
        foreach($orders as $order){
           
            if( $order->bundleid != null){
                $bundleItems = $this->getBarBundles($order->bundleid);
                    foreach($bundleItems as $item){
                        if($item->menuID == $order->menuID){
                        array_push($bundles,array(
                            'kitchen_id'=> $order->id,
                            'tableno'=>$order->tableno,
                            'date_ordered' =>$order->created_at,
                            'order_id'=> $order->order_id,
                            'status'=> $order->kitchenStatus,
                            'ordered'=> $order->orderQty,
                            'details'=> array(
                                [
                                    'bundleName'=> $item->bundleName,
                                    'qty'=>  $item->qty,
                                    'menuID'=>  $item->menuID,
                                    'itemName'=>  $item->itemName
                                    ]
                            )
                        )
                    );
                    }
                }
                         
                
            }else {
                $singles = $this->getBarSingle($order->menuID);
                foreach($singles as $single){
                    if($single != null ){
                    array_push($bundles,array(
                        'kitchen_id'=> $order->id,
                        'tableno'=>$order->tableno,
                        'date_ordered' =>$order->created_at,
                        'order_id'=> $order->order_id,
                        'status'=> $order->kitchenStatus,
                        'ordered'=> $order->orderQty,
                        'details'=>array(
                            ['bundleName'=> null,
                            'qty'=> null,
                            'menuID'=> $single->menuID,
                            'itemName'=> $single->itemName]
                        ))); 
                    }
                }
             
               
            }
            
        }

        return response()->json([
            'details' =>$bundles
        ]);
    }

    function getBarBundles($bundleid){
        $kitchen = DB::table('bundles')
        ->select('bundles.name AS bundleName','menus.name AS itemName','menus.menuID','bundle_details.qty','bundles.bundleid as bundleid')
                   ->join('bundle_details','bundle_details.bundleid','=','bundles.bundleid')
                   ->join('menus',"menus.menuID",'=','bundle_details.menuID')
                   ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
                   ->join('categories','categories.categoryid','=','sub_categories.categoryid')
                   ->where('categories.categoryname','=','Drinks')
                   ->where('bundles.bundleid',$bundleid)
                   ->get();
        return $kitchen;
    }

    function getBarSingle($menuid){
                    return DB::table('menus')
                    ->select('menus.name AS itemName','menus.menuID')
                    ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
                    ->join('categories','categories.categoryid','=','sub_categories.categoryid')
                    ->where('categories.categoryname','=','Drinks')
                    ->where('menus.menuID',$menuid)
                    ->get();
        
    }

    public function getBarKitchenOrders($tableno){
        // $orders = DB::table('kitchenrecords')
        // ->select('kitchenrecords.bundleid','kitchenrecords.menuID','orders.order_id','orders.tableNo','kitchenrecords.id',
        // 'kitchenrecords.created_at','kitchenrecords.orderQty','kitchenrecords.status' )
        // ->join('orders','orders.order_id','=','kitchenrecords.order_id')
        // ->where('orders.tableno',$tableno)
        // ->get();
        // $bundles = [];

        // foreach($orders as $order){
        //     if($order->bundleid != null  && $order->menuID !=null ){
        //         $items = $this->getBarKitchenBundles($order->bundleid);
        //         $singles = $this->getBarKitchenSingle($order->menuID);
        //             if($items !=null){
        //                 foreach($items as $item){
        //                    array_push($bundles,array(
        //                     'kitchen_id'=> $order->id,
        //                     'date_ordered' =>$order->created_at,
        //                     'order_id'=> $order->order_id,
        //                     'status'=> $order->status,
        //                     'ordered'=> $order->orderQty,
        //                     'details'=>$item)); 
        //                 }
        //             }
        //             if($singles != null ){
        //             foreach($singles as $single){
        //             array_push($bundles,array(
        //                 'kitchen_id'=> $order->id,
        //                 'date_ordered' =>$order->created_at,
        //                 'order_id'=> $order->order_id,
        //                 'status'=> $order->status,
        //                 'ordered'=> $order->orderQty,
        //                 'details'=>[$single])); 
                      
        //             }
        //         }
        //     }
        //     else if( $order->bundleid == null  && $order->menuID !=null ){
                
        //         foreach($singles as $single){
        //             if($single != null ){
        //             array_push($bundles,array(
        //                 'kitchen_id'=> $order->id,
        //                 'date_ordered' =>$order->created_at,
        //                 'order_id'=> $order->order_id,
        //                 'status'=> $order->status,
        //                 'ordered'=> $order->orderQty,
        //                 'details'=>[$single])); 
        //             }
        //         }
        //     }
        // }

        // return response()->json([
        //     'details' =>$orders
        // ]);
        $orders = DB::table('kitchenrecords')
        ->select(
            'kitchenrecords.status as kitchenStatus',
            'kitchenrecords.id',
            'orders.tableno',
            'kitchenrecords.created_at',
            'orders.order_id',
            'kitchenrecords.orderQty',
            'kitchenrecords.bundleid',
            'kitchenrecords.menuID',
            'orders.status as orderStatus'
        )
        ->join('orders', 'orders.order_id','=','kitchenrecords.order_id')
        ->where('orders.tableno',$tableno)
        ->get();
        $bundles = [];
        foreach($orders as $order){
           
            if( $order->bundleid != null){
                $bundleItems = $this->getBarKitchenBundles($order->bundleid);
                    foreach($bundleItems as $item){
                        if($item->menuID == $order->menuID){
                        array_push($bundles,array(
                            'kitchen_id'=> $order->id,
                            'tableno'=>$order->tableno,
                            'date_ordered' =>$order->created_at,
                            'order_id'=> $order->order_id,
                            'status'=> $order->kitchenStatus,
                            'ordered'=> $order->orderQty,
                            'billStatus'=> $order->orderStatus,
                            'details'=> array(
                                [
                                    'bundleName'=> $item->bundleName,
                                    'qty'=>  $item->qty,
                                    'menuID'=>  $item->menuID,
                                    'itemName'=>  $item->itemName
                                    ]
                            )
                        )
                    );
                    }
                }
                         
                
            }else {
                $singles = $this->getBarKitchenSingle($order->menuID);
                foreach($singles as $single){
                    if($single != null ){
                    array_push($bundles,array(
                        'kitchen_id'=> $order->id,
                        'tableno'=>$order->tableno,
                        'date_ordered' =>$order->created_at,
                        'order_id'=> $order->order_id,
                        'status'=> $order->kitchenStatus,
                        'ordered'=> $order->orderQty,
                        'billStatus'=> $order->orderStatus,
                        'details'=>array(
                            ['bundleName'=> null,
                            'qty'=> null,
                            'menuID'=> $single->menuID,
                            'itemName'=> $single->itemName]
                        ))); 
                    }
                }
             
               
            }
            
        }

        return response()->json([
            'details' =>$bundles
        ]);
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
    function getBarKitchenSingle($menuid){
      
                   return DB::table('menus')
                    ->select('menus.name AS itemName','menus.menuID')
                    ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
                    ->join('categories','categories.categoryid','=','sub_categories.categoryid')
                    ->where('menus.menuID',$menuid)
                    ->get();
        
    }
   
}