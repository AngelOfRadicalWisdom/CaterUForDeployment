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
    //monthly+yearly sales
    public function salesChart()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $monthly = $this->getMonthlyRevenue();
        $yearly = $this->getYearlyRevenue();
        foreach ($monthly as $row) {
            $monthlySales[] = $row->total;
            $monthName[] = $row->month;
            $MonthlySalesStr = implode(",", $monthlySales);
            $monthNameStr = "'" . implode("','", $monthName) . "'";
        }
        foreach ($yearly as $row) {
            $yearlySales[] = $row->total;
            $yearName[] = $row->year;
            $yearlySalesStr = implode(",", $yearlySales);
            $yearNameStr = "'" . implode("','", $yearName) . "'";
        }
        return view('admin.report.sales')->with(compact('userFname', 'userLname', 'MonthlySalesStr', 'monthNameStr', 'yearlySalesStr', 'yearNameStr', 'userImage'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    }
    //user defines date of sales report
    public function getSalesUserDefined(Request $request)
    {
        try{
        $sum = 0;
        $from = date($request->from);
        $to = date($request->to);
        $totalOrder = Order::selectRaw("sum(total) as total,date_ordered,DATE_FORMAT(date_ordered,'%M %d %Y') as yearMonth,TIME(date_ordered) as time")
            ->whereDate('date_ordered', '>=', $from)
            ->whereDate('date_ordered', '<=', $to)
            ->where('status', 'paid')
            ->groupBy('date_ordered')
            ->get();

        foreach ($totalOrder as $revenue) {

            $totalRev[] = $revenue->total;

            $year[] = $revenue->yearMonth;
        }
        if (count($totalOrder) == 0) {
            return \Response::json(['status' => 500]);
        } else {
            return \Response::json(['status' => 200, 'year' => $year, 'totalRev' => $totalRev]);
        }
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong ")->withInput();
    }
    }
    //get the revenue per year
    private function getYearlyRevenue()
    {
        try{
        $totalOrder = Order::select(DB::raw('YEAR(date_ordered) as year, sum(total) as total'))
            ->where('status', 'paid')
            ->groupBy(DB::raw('YEAR(date_ordered)'))
            ->get();
        return ($totalOrder);
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    }
    //get the revenue per month
    private function getMonthlyRevenue()
    {
        try{
        $date = Carbon::now();
        $totalOrder = Order::select(DB::raw('MONTHNAME(date_ordered) as month, sum(total) as total'))
            ->whereYear('date_ordered', $date->year)
            ->where('status', 'paid')
            ->groupBy(DB::raw('MONTHNAME(date_ordered)'))
            ->get();
        return ($totalOrder);
    }
catch (\PDOException $e) {
    return back()->withError("Sorry Something Went Wrong ")->withInput();
}
}
}