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
       // $allOrders = Order::all();       
        $orderDetailsName = DB::table('orders')
          ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
          ->join('menus','order_details.menuID','=','menus.menuID')
          ->selectRaw('group_concat(menus.name) as menuname')
          ->selectRaw('orders.order_id')
          ->selectRaw('orders.total')
          ->selectRaw('orders.date_ordered')
          ->groupBy('orders.order_id')
          ->get();
          $result = [];
          $orderid=[];
          $total=[];
          $dateOrdered=[];
          foreach ($orderDetailsName as $row) {
            $result[] = explode(',', $row->menuname);
            $orderid[]= explode(',',$row->order_id);
            $total[]= explode(',',$row->total);
            $dateOrdered[]= explode(',',$row->date_ordered);

          }
          $menudetails = array_values($result);
          $Oids=array_values($orderid);
          $bill=array_values($total);
          $orderDate= array_values($dateOrdered);
        // dd($orderDetailsName);
    return view('admin.dashboard', compact('userImage', 'userFname', 'userLname','menudetails','Oids','bill','orderDate'));
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
        $aprSettings = new AprioriSettings();
        $checkdb = DB::table('aprioriSettings')->get();
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

}
