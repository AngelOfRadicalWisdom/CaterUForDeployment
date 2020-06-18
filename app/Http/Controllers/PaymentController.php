<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderDetail;
use App\Order;
use App\Customer;
use DB;
class PaymentController extends Controller
{

    public function getSubTotal($order_id){
        $orders = Order::find($order_id);
        $subtotal = DB::table('order_details')
                ->where('order_id', $orders->order_id)
                ->where('status','served')
                ->sum('subtotal');


        return response()->json([
            'subtotal'  => $subtotal
        ]);
    }


    public function discount($order_id,Request $request){
        $order = Order::find($order_id);
        $amount = $order->total;
        $vat = .12;
        $numberOfID = 2;
        switch($request->discountType){
            case 'senior':
                $senior = .20;
                $vatExemptRate = round($amount / 1.12,2);//500/1.12 = 446.43
                $discount = round($vatExemptRate * $senior,2);//446.63*.20 = 89.29
                $seniorDiscounted = round($vatExemptRate - $discount,2);// 446.43 - 89.29 = 357.14//
                $order->discount = $discount;
                $order->vatExemptRate = $vatExemptRate;
                $order->discountedTotal = $seniorDiscounted;
                $order->discountType='senior';
                $order->VATableSales = NULL;
                $order->vat = NULL;
                break;
            default:
                $vatableSales = round($order->total/1.12,2);
                $vat = round($vatableSales * $vat,2);
                $order->VATableSales = $vatableSales;
                $order->vat = $vat;
                $order->discountType = NULL;
                $order->discount = NULL;
                $order->discountedTotal = NUll;
                $order->vatExemptRate = NULL;
                break;
        }
        $order->save();
            return response()->json([
                'order' => $order
        ]);

    }
    public function setTotal(Request $request){
        $total = DB::table('order_details')
                 ->where('order_id', $request->order_id)
                 ->sum('subtotal');
        DB::table('orders')->where('order_id',$request->order_id)->update(['total' => $total]);
         return response()->json([
             'total' => $total
         ]);

     }
     public function printReceipt(Request $request){
        $orders = Order::find($request->order_id);
         $orders->cashTender = $request->cashTender;
         $orders->change = $request->change;
        $orders->status = $request->status;
        $orders->total = $request->total;
        $orders->save();

        return response()->json([
            'message' => 'Success'
        ]);
    }

}
