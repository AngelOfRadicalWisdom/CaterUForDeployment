<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\AprioriSettings;
use App\Employee;
use App\Menu;
use App\Order;
use Carbon\Carbon;
use App\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class AdminController extends Controller
{
    //exception declarations 
    private $customExceptions;
    //exception constructor
    public function __construct(CustomExceptions $customExceptions)
    {
        $this->customExceptions = $customExceptions;
    }
    //landing page function
    public function landing()
    {
        return view('admin.landing');
    }
    //profile function 
    public function profile()
    {
      try{ 
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        return view('profile', compact('userFname', 'userLname', 'userImage', 'user'));
      }
      catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong ")->withInput();
    }
    }
    //saving the update profile function
    public function SaveUpdateProfile(Request $request, $employeeID)
    {
        //exception part
        try {
            $employee = $this->customExceptions->nameException($request, $employeeID);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        } catch (\Exception $e) {
            return back()->withError('Something Went Wrong')->withInput();
        }
        try{
        $user = Employee::find($employeeID);
        //if thers is no image uploaded 
        if ($request->file('image') == NULL) {
            $user->empfirstname = $request->empfirstname;
            $user->emplastname  = $request->emplastname;
            $user->username = $request->username;
            $user->image = $user->image;
            $user->save();
        } else {
            $filename = $request->file('image')->getClientOriginalName();

            $path = public_path() . '/employee/employee_images';
            $request->file('image')->move($path, $filename);

            $user->empfirstname = $request->empfirstname;
            $user->emplastname  = $request->emplastname;
            $user->username = $request->username;
            $user->image = $filename;
            $user->save();
        }

        return redirect('/admin/profile')->with('success', 'Profile Successfully');
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
    }
    }
    //admin dashboard
    public function dashboard()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $date = Carbon::now();
        //monthly entries of the charts
        $monthly = Order::select(DB::raw('MONTHNAME(date_ordered) as month, sum(total) as total'))
            ->whereYear('date_ordered', $date->year)
            ->where('status', 'paid')
            ->groupBy(DB::raw('MONTHNAME(date_ordered)'))
            ->get();
        //yearly entries of the charts
        $yearly = Order::select(DB::raw('YEAR(date_ordered) as year, sum(total) as total'))
            ->where('status', 'paid')
            ->groupBy(DB::raw('YEAR(date_ordered)'))
            ->get();
        //employee count
        $countemp = Employee::selectRaw('COUNT(empid) as count')
            ->get();
        //manages the date entries so that it can be used for the chart
        foreach ($countemp as $row) {
            $countEmployee = $row->count;
        }
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
        //ratings area of the dashboard
        $maxRating = 5;
        $ratings = Rating::selectRaw("Count(star) as totalstar,star")->groupBy('star')->get();
        $Average = Rating::selectRaw("CAST(AVG (star) AS DECIMAL (10,1)) as avg")->get();
        //Manages the data for ratings so that it can be used for the charts
        foreach ($Average as $row) {
            $avg[] = $row->avg;
            $AverageStr = implode(",", $avg);
        }
        foreach ($ratings as $row) {
            $rates[] = $row->totalstar;
            $ratesStr = implode(",", $rates);
        }
        return view('admin.dashboard', compact('maxRating', 'AverageStr', 'ratesStr', 'userImage', 'userFname', 'userLname', 'countEmployee', 'MonthlySalesStr', 'monthNameStr', 'yearlySalesStr', 'yearNameStr'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    
    }
    //mobile side show menulist by date
    public function showMenuListByDate(Request $request)
    {
        $from = $request->from;
        $to = $request->to;

        $lists = DB::table('order_details')
            ->whereBetween('created_at', [$from, $to])->get();

        return response()->json([
            'lists' => $lists
        ]);
    }
    //setting the support and confidence 
    public function setApriori()
    {
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        return view('pages.apriorisettings', compact('userImage', 'userFname', 'userLname'));
        
    }
    //saving the user defined support and confidence
    public function saveAprioriSettings(Request $request)
    {
        //exception part
        try {
             $this->customExceptions->AprioriException($request);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        try{
        $aprSettings = new AprioriSettings();
        $checkdb = DB::table('bundle_menus')->get();
        //if null save directly
        if ($checkdb == NULL) {
            $aprSettings->support = $request->support;
            $aprSettings->confidence = $request->confidence;
        }
        //else truncate the database so that there will only be one entry
        else {
            $aprSettings->truncate();
            $aprSettings->support = $request->support;
            $aprSettings->confidence = $request->confidence;
        }
        $aprSettings->save();
        return redirect('/dashboard')->with('success', ' Support and Confidence Successfully updated');
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
    }
}

}
