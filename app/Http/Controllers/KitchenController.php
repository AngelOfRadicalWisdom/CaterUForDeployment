<?php

namespace App\Http\Controllers;

use Carbon;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\OrderDetail;
use App\Menu;
use App\SubCategory;
use App\Category;
use App\Order;
use DB;

class KitchenController extends BaseController
{
    //mobile retrive kitchen orders
    public function kitchenOrders()
    {
        $orders = DB::table('categories')
            ->join('sub_categories', 'categories.categoryid', '=', 'sub_categories.categoryid')
            ->join('menus', 'sub_categories.subcatid', '=', 'menus.subcatid')
            ->join('order_details', 'menus.menuID', '=', 'order_details.menuID')
            ->where('categories.categoryname', '!=', 'Drinks')
            ->where('order_details.status', '!=', 'served')
            ->where('order_details.status', '!=', 'serving')
            ->where('order_details.status', '!=', 'done')
            ->get();

        return response()->json([
            'orders' => $orders
        ]);
    }
    //mobile change status to ready
    public function changeStatusReady($id)
    {
        $ready = OrderDetail::find($id);

        if ($ready) {
            $ready->status = 'Ready';
            $ready->save();
        }

        return response()->json([
            'message' => 'Menu is ready'
        ]);
    }
    //mobile retrieve ready menus
    public function readyMenu()
    {
        $allOrders = OrderDetail::all();
        $allCategories = Category::all();
        $names = array();

        foreach ($allOrders as $orders) {
            foreach ($orders->order as $ords) {
                $o = Order::find($orders->order_id);
                $menus = Menu::find($orders->menuID);
                $menus->subCategory();
                $sub = SubCategory::find($menus->subcatid);
                $sub->category();
                $catid = $menus->subcategory->categoryid;

                if ($orders->status == 'Ready' && $catid != 6) {
                    array_push($names, array(
                        'tableno' => $o->tableno,
                        'name' => $menus->name,
                        'menu id' => $menus->menuID,
                        'order_id' => $orders->id,
                        'quantity' => $orders->orderQty,
                        'date_ordered' => $orders->date_ordered
                    ));
                }
            }
        }
        return response()->json([
            'orders' => $names
        ]);
    }
    //mobile retrieve the ready menu List
    public function getMenuReadyList()
    {
        $list = DB::table('order_details')
            ->join('orders', 'orders.order_id', '=', 'order_details.order_id')
            ->join('menus', 'menus.menuID', '=', 'order_details.menuID')
            ->where('order_details.status', 'Ready')
            ->orderBy('order_details.updated_at', 'asc')->get();

        return response()->json([
            'lists' => $list
        ]);
    }
}
