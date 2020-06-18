<?php

namespace App\Http\Controllers;
use App\OrderDetail;
use App\Order;
use App\Menu;
use App\RestaurantTable;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function salesChart(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $monthly=$this->getMonthlyRevenue();
        $yearly=$this->getYearlyRevenue();
        foreach($monthly as $row){
            $monthlySales[]=$row->total;
            $monthName[]=$row->month;
            $MonthlySalesStr=implode(",",$monthlySales);
            $monthNameStr="'".implode("','",$monthName)."'";
        
        }
        foreach($yearly as $row){
            $yearlySales[]=$row->total;
            $yearName[]=$row->year;
            $yearlySalesStr=implode(",",$yearlySales);
            $yearNameStr="'".implode("','",$yearName)."'";
        }

       //dd($monthly);
    // return view('admin.report.sales')->with(compact('userFname','userLname','monthly','yearly'));
    return view('admin.report.sales')->with(compact('userFname','userLname','MonthlySalesStr','monthNameStr','yearlySalesStr','yearNameStr','userImage'));
     
}
public function getSalesUserDefined(Request $request){
    $sum=0;
    $from = date($request->from);
    $to = date($request->to);
//    $totalOrder=Order::selectRaw('group_concat(total) as total ' )
//    ->selectRaw('group_concat(date_ordered) as date')
//     -> whereDate('date_ordered', '>=', $from)
//    ->whereDate('date_ordered', '<=', $to)
//    ->groupBy('date_ordered')
//    ->get();
$totalOrder=Order::selectRaw("sum(total) as total,date_ordered,DATE_FORMAT(date_ordered,'%M %d %Y') as yearMonth,TIME(date_ordered) as time")
-> whereDate('date_ordered', '>=', $from)
   ->whereDate('date_ordered', '<=', $to)
   ->where('status','paid')
   ->groupBy('date_ordered')
   ->get();
// dd($totalOrder);
   foreach($totalOrder as $revenue){
       //dd($revenue->total);
       $totalRev[] = $revenue->total;
       //$dateordered[]=$revenue->date_ordered;
       $year[]=$revenue->yearMonth;
   }
   if(count($totalOrder)==0){
    return \Response::json(['status'=>500]);
}
else{
   // dd($request->all());
//return redirect('/trial')->with(compact('totaRevStr','yearStr','monthStr','dayStr'));
return \Response::json(['status'=>200,'year'=>$year,'totalRev'=>$totalRev]);

}

}
private function getYearlyRevenue(){
    $totalOrder = Order::select(DB::raw('YEAR(date_ordered) as year, sum(total) as total'))
    ->where('status','paid')
    ->groupBy(DB::raw('YEAR(date_ordered)'))
    ->get();
    return($totalOrder);

}
private function getMonthlyRevenue(){
    $date=Carbon::now();
    $totalOrder = Order::select(DB::raw('MONTHNAME(date_ordered) as month, sum(total) as total'))
    ->whereYear('date_ordered',$date->year)
    ->where('status','paid')
    ->groupBy(DB::raw('MONTHNAME(date_ordered)'))
    ->get();
    return($totalOrder); 
}
    
}
 