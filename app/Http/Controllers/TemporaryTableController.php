<?php

namespace App\Http\Controllers;

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
    public function getCartItems($order_id)
    {
        $cart_items = DB::table('carts')
            ->join('menus', 'carts.menuID', '=', 'menus.menuID')
            ->select('carts.*', 'menus.name', 'menus.price')
            ->where('carts.order_id', $order_id)
            ->get();

        return response()->json([
            'data' => $cart_items
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
    // public function saveToTemporaryKitchenTable(Request $request){
    //     for($i= 0; $i < $request->orderQty; $i++){
    //     $kitchenorders = new Kitchen();
    //     $kitchenorders->orderQty = 1;
    //     $kitchenorders->menuID = $request->menuID;
    //     $kitchenorders->order_id = $request->order_id;
    //     $kitchenorders->status = $request->status;

    //     $kitchenorders->save();
    //     }

    //     return response()->json([
    //     'message' => 'Saved to kitchen'
    //        // $request->orderQty
    //     ]);
    // }
    public function getKitchenOrders()
    {
        $orders = DB::table('kitchenrecords')
            ->join('orders', 'orders.order_id', '=', 'kitchenrecords.order_id')
            ->join('menus', 'menus.menuID', '=', 'kitchenrecords.menuID')
            ->join('sub_categories', 'menus.subcatid', '=', 'sub_categories.subcatid')
            ->join('categories', 'sub_categories.categoryid', '=', 'categories.categoryid')
            ->where('categories.categoryname', '!=', 'Drinks')
            ->where('kitchenrecords.status', '=', 'waiting')
            ->orderBy('kitchenrecords.created_at', 'asc')->get();

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
        $status->status = 'for serving';
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
    public function getAllPreparedItems()
    {
        $orders = DB::table('kitchenrecords')
            ->join('orders', 'orders.order_id', '=', 'kitchenrecords.order_id')
            ->join('menus', 'menus.menuID', '=', 'kitchenrecords.menuID')
            ->join('sub_categories', 'menus.subcatid', '=', 'sub_categories.subcatid')
            ->join('categories', 'sub_categories.categoryid', '=', 'categories.categoryid')
            ->where('categories.categoryname', '!=', 'Drinks')
            ->where('kitchenrecords.status', '=', 'preparing')
            ->orderBy('kitchenrecords.updated_at', 'asc')->get();

        return response()->json([
            'orders' => $orders
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

    public function checkForReadyOrders()
    {

        $data = array();
        $result;
        $orders = DB::table('kitchenrecords')
            ->select('kitchenrecords.status', 'kitchenrecords.orderQty', 'kitchenrecords.id', 'orders.tableno', 'tables.status as tableStatus')
            ->join('orders', 'orders.order_id', '=', 'kitchenrecords.order_id')
            ->join('tables', 'tables.tableno', '=', 'orders.tableno')
            ->where('tables.status', '=', 'Occupied')
            ->orderBy('kitchenrecords.created_at', 'asc')->get();

        foreach ($orders as $order) {
            $data[$order->tableno][] = $order;
        }


        return response()->json([
            "readyorders" => $data
        ]);
    }
    public function getAllCompleteList()
    {
        $orders = DB::table('kitchenrecords')
            ->join('orders', 'orders.order_id', '=', 'kitchenrecords.order_id')
            ->join('menus', 'menus.menuID', '=', 'kitchenrecords.menuID')
            ->join('sub_categories', 'menus.subcatid', '=', 'sub_categories.subcatid')
            ->join('categories', 'sub_categories.categoryid', '=', 'categories.categoryid')
            ->where('categories.categoryname', '!=', 'Drinks')
            ->where('kitchenrecords.status', '=', 'ready')
            ->orderBy('kitchenrecords.updated_at', 'desc')->get();

        return response()->json([
            'orders' => $orders
        ]);
    }
    public function getAllCompleteDrinks()
    {
        // $orders2 = DB::table('kitchenrecords')
        //     ->join('orders', 'orders.order_id', '=', 'kitchenrecords.order_id')
        //     ->join('menus', 'menus.menuID', '=', 'kitchenrecords.menuID')
        //     ->join('sub_categories', 'menus.subcatid', '=', 'sub_categories.subcatid')
        //     ->join('categories', 'sub_categories.categoryid', '=', 'categories.categoryid')
        //   // ->selectRaw("TIME(kitchenrecords.updated_at) as time_updated,menus.menuID")
        //     ->where('categories.categoryname', '=', 'Drinks')
        //     ->where('kitchenrecords.status', '=', 'ready')
        //     ->orderBy('kitchenrecords.updated_at', 'desc')->get();

        // return response()->json([
        //     'orders' => $orders2
        // ]);
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
}
