<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\OrderDetail;
use App\Category;
use App\SubCategory;
use App\Menu;
use App\Order;
use App\Kitchen;
use App\TemporaryOrders;
use DB;

class OrderDetailController extends BaseController
{
 
    public function orderList($order_id){ 
        $bundles = array();
        $items = array();

    $orders = DB::table('temporary_orders')
    ->select(
        'menus.name',
        'temporary_orders.orderQty',
        'temporary_orders.id as kitchenId',
        'temporary_orders.tempId',
        'temporary_orders.bundleid',
        'temporary_orders.qtyServed',
        'temporary_orders.order_id',
        'temporary_orders.status',
        'temporary_orders.order_details_id'
        )
    ->join('menus','menus.menuID','=','temporary_orders.menuID')
    ->where('temporary_orders.order_id',$order_id)
    ->orderBy('temporary_orders.bundleid','ASC')
    ->get();

    foreach($orders as $o){
        if($o->bundleid !=null){
            $bundleName = $this->getBarKitchenBundles($o->bundleid);
            $bundleQty = $this->getBundleQty($o->bundleid);
            
                    array_push($bundles,array(
               'name'=> $o->name,
                'orderQty'=> $o->orderQty,
                'kitchenId'=>$o->kitchenId,
                'tempId'=> $o->tempId,
                'bundleid'=> $o->bundleid,
                'bundleName'=> $bundleName,
                'bundleQty'=> $bundleQty,
                'qtyServed'=> $o->qtyServed,
                'order_id'=>$o->order_id,
                'status'=> $o->status,
                'orderdetailsid'=>$o->order_details_id
            )); 

        }else{
            array_push($bundles,array(
                'name'=> $o->name,
                 'orderQty'=> $o->orderQty,
                 'kitchenId'=>$o->kitchenId,
                 'tempId'=> $o->tempId,
                 'bundleid'=> null,
                 'bundleName'=> null,
                 'qtyServed'=> $o->qtyServed,
                 'order_id'=>$o->order_id,
                 'status'=>$o->status,
                 'bundleQty'=> null,
                 'orderdetailsid'=>$o->order_details_id
             )); 
        }
    }
    return response()->json([
        'data' => $bundles
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
        return  $kitchen[0]->bundleName;
    }
    function getBundleQty($bundleid){
        $kitchen = DB::table('bundles') 
        ->select('bundles.name AS bundleName','menus.name AS itemName','menus.menuID','bundle_details.qty','bundles.bundleid as bundleid')
                   ->join('bundle_details','bundle_details.bundleid','=','bundles.bundleid')
                   ->join('menus',"menus.menuID",'=','bundle_details.menuID')
                   ->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
                   ->join('categories','categories.categoryid','=','sub_categories.categoryid')
                   ->where('bundles.bundleid',$bundleid)
                   ->get();
        return  $kitchen[0]->qty; 
    }
    

    function getBundles(){
        return DB::table('bundles')
        ->select('name as bundleName')
        ->where('bundleid',$bundleid)
        ->get();
    }


    public function getTotal($order_id){
        $orderDetails = OrderDetail::where('order_id',$order_id)->get();
        $total = 0;
        foreach ($orderDetails as $order) {
            $total += $order->subtotal;
        }
        return response()->json([
            'total' => $total
        ]);
    }

    public function getAllServedMenus()
    {

        $allOrders = OrderDetail::all();
        $allCategories = Category::all();
        $drinks = array();
        $result = array();
        foreach ($allOrders as $orders) {
            foreach ($orders->order as $ords) {

                $order = Order::find($orders->order_id);
                $menus = Menu::find($orders->menuID);
                $menus->subCategory();
                $sub = SubCategory::find($menus->subcatid);
                $sub->category();
                $catid = $menus->subcategory->categoryid;


                if ($orders->status == 'served') {
                    array_push($drinks, array(
                        'order_id' => $order->order_id,
                        'tableno' => $order->tableno,
                        'name' => $menus->name,
                        'menu_id' => $menus->menuID,
                        'detail_id' => $orders->id,
                        'quantity' => $orders->orderQty,

                    ));
                }
            }
        }

        foreach ($drinks as $element => $value) {
            $result[$value['order_id']][] = $value;
        }
        return response()->json([

            'result' => $result
        ]);
    }
    public function cancelOrderMenu($id)
    {
        $orders = OrderDetail::find($id);
        $order = new OrderDetail;
        $order->status = "cancelled";

        $order->save();
        return response()->json([
            'message' => 'Order is cancelled'
        ]);
    }

    public function setServeQty(Request $request)
    {
        //SINGLE ORDERS ONLY

        $temp = TemporaryOrders::find($request->tempId);
        $temp->qtyServed-=$request->noItemToServe;
        $temp->save();

        if($temp->bundleId!=null){
            $records = OrderDetail::find($request->id);
            $records->qtyServed -= $request->noItemToServe;
            $records->save();

            if($records->qtyServed == 0){
                $records = OrderDetail::find($request->id);
                $records->status = "served";
                $records->save();
            }
        }else{

            if($temp->qtyServed == 0){
                $records = OrderDetail::find($request->id);
                $records->qtyServed -= $request->noItemToServe;
                $records->status = "served";
                $records->save();

                $temp = TemporaryOrders::find($request->tempId);
                $temp->status = "served";
                $temp->save();
            }
          
        }

        return response()->json([
            'message' => $request->noItemToServe
        ]);
    }
    
    public function setServeQtyBundleItem(Request $request)
    {
        //BUNDLE ORDERS ONLY

        $temp = TemporaryOrders::find($request->tempId);
        $temp->qtyServed-=$request->noItemToServe;
        $temp->save();

        $item = $this.getBundleQty($request->tempId);
        if(!$item){
            $records = OrderDetail::find($request->id);
            $records->qtyServed -= $request->noItemToServe;
            $records->status = 'served';
            $records->save(); 
        }
        return response()->json([
            'message' => $request->noItemToServe
        ]);
    }
    function getBundleItems($id){

            $items = DB::table('temporary_orders')
            ->where('status','ready')
            ->where('order_details_id',$id)
            ->get();

            if($items){
                $hasItem = true;
            }else $hasItem = false;

            return response()->json(
                $hasItem
            );
            
        }

    public function serveBundle(){

        $records = OrderDetail::find($request->id);
        $records->status = 'served';
        $records->save();

        return response()->json([
            'message' => $request->noItemToServe
        ]);
    }

    
    public function isServed($id,Request $request)
    {
        $status = '';
        $servedQty = OrderDetail::whereId($id)->pluck('qtyServed')->first();
        $servedQtyTemp = TemporaryOrders::whereId('tempId',$request->tempId)->get();

        if ($servedQty === 0) {
            $detail = OrderDetail::find($id);
            $detail->status = 'served';
            $detail->save();

            $detail = TemporaryOrders::find($id);
            $detail->status = 'served';
            $detail->save();
            $status = 'Order is served.';
        } else {
            $status = 'Orders is being prepared.';
        }
       
        return response()->json([
            'status' => $status
        ]);
    }

    public function isServedBundle($id,Request $request){
        $status = Kitchen::find($id);
        $status->status = 'serving';
        $status->save();
        $bundle = Kitchen::find($request->id);
        $bundle->status = 'serving';
        $bundle->save();
        

        return response()->json([
            'message' => 'Status updated to for serving'
        ]);
    }

    public function isForServingBundles($id,Request $request)
    {
        $status = Kitchen::find($id);
        $status->status = 'serving';
        $status->save();
        $bundle = Kitchen::find($request->id);
        $bundle->status = 'serving';
        $bundle->save();
        

        return response()->json([
            'message' => 'Status updated to for serving'
        ]);
    }

}