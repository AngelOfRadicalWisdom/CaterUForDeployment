<?php

namespace App\Http\Controllers;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Cart;
use App\Kitchen;
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
    
    public function getKitchenOrders(){
        $orders = DB::table('kitchenrecords')
        ->select('order_details.date_ordered','menus.name','kitchenrecords.status','menus.menuID','kitchenrecords.bundleid')
        ->join('orders','orders.order_id','=','kitchenrecords.order_id')
        ->join('order_details', 'order_details.order_id','=','orders.order_id')
        ->join('menus','menus.menuID','=','kitchenrecords.menuID')
        ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
        ->join('categories','sub_categories.categoryid','=','categories.categoryid')
        ->where('categories.categoryname','!=', 'Drinks')
        ->where('kitchenrecords.status','=','waiting')
        ->orderBy('kitchenrecords.created_at','asc')->get();

     

        return response()->json([
            'orders' => $orders
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
    public function isForServing($id)
    {
        $status = Kitchen::find($id);
        $status->status = 'serving';
        $status->save();

        return response()->json([
            'message' => 'Status updated to for serving'
        ]);
    }

    public function isReady($id)
    {
        $status = Kitchen::find($id);
        $status->status = 'ready';
        $status->save();

        return response()->json([
            'message' => 'Status updated to for serving'
        ]);
    }
    public function prepare($id)
    {
        $status = Kitchen::find($id);
        $status->status = 'preparing';
        $status->save();

        return response()->json([
            'message' => 'status updated'
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

        // foreach($orders as $order){
        //     array_push($list,array(
        //         'date_ordered' => $order->date_ordered.toTimeString(),
        //         'name'=> $list->name
        //     ));
        // }

        return response()->json([
            'orders' => $orders
        ]);
    }

    public function getBarKitchenOrders(){
        $orders = DB::table('kitchenrecords')->get();
        $kitchen = [];
        $bar = [];

        foreach($orders as $order){
            if($order['bundleid']!= null  && $order['menuID']==null ){
                $bundles = $this->getMealBundles($order['bundleid']);
            }
        }

        return response()->json([
            $bundles
        ]);
    }

    function getMealBundles($bundleid){
        $kitchen = DB::table('bundles')
                   ->join('bundle_details','bundle_details.bundleid','=','bundles.bundleid')
                   ->join('menus',"menus.menuID",'=','bundle_details.menuID')
                   ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
                   ->join('categories','categories.categoryid','=','sub_categories.categoryid')
                   ->where('bundles.bundleid',$bundleid)
                   ->get();
        return $kitchen;
    }
   
}