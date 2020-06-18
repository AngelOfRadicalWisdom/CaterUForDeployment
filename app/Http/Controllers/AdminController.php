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
use Illuminate\Database\QueryException ;
class AdminController extends Controller
{
    private $customExceptions;

    public function __construct(CustomExceptions $customExceptions)
    {
        $this->customExceptions = $customExceptions;
    }
    public function landing(){
        return view('admin.landing');
    }
    public function profile(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        return view('profile',compact('userFname','userLname','userImage','user'));
    }
    public function SaveUpdateProfile(Request $request,$employeeID){
        try{
    $employee=$this->customExceptions->nameException($request,$employeeID);
   
        }
        catch(\PDOException $e){
            return back()->withError($e->getMessage())->withInput();
        }
        catch(\Exception $e){
            return back()->withError('Something Went Wrong')->withInput();
        }
        $user = Employee::find($employeeID);
        if($request->file('image')==NULL){
            $user->empfirstname = $request->empfirstname;
            $user->emplastname  = $request->emplastname;
            $user->username = $request->username;
            $user->image=$user->image;
            $user->save();
    
        return redirect('/admin/profile')->with('success','Profile Successfully');
          // dd($request);
        }
        else{
        $filename = $request->file('image')->getClientOriginalName();
    
        $path = public_path().'/employee/employee_images';
        $request->file('image')->move($path, $filename);
    
        $user->empfirstname = $request->empfirstname;
            $user->emplastname  = $request->emplastname;
            $user->username= $request->username;
            $user->image=$filename;
            $user->save();
    
            return redirect()->to('/admin/profile');
        }
      
    }
    public function dashboard(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $date=Carbon::now();
        $monthly= Order::select(DB::raw('MONTHNAME(date_ordered) as month, sum(total) as total'))
        ->whereYear('date_ordered',$date->year)
        ->where('status','paid')
        ->groupBy(DB::raw('MONTHNAME(date_ordered)'))
        ->get();
        $yearly=Order::select(DB::raw('YEAR(date_ordered) as year, sum(total) as total'))
        ->where('status','paid')
        ->groupBy(DB::raw('YEAR(date_ordered)'))
        ->get();
        $countemp=Employee::selectRaw('COUNT(empid) as count')
        ->get();
        foreach($countemp as $row){
            $countEmployee=$row->count;
        }
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
        $maxRating=5;
        $ratings=Rating::selectRaw("Count(star) as totalstar,star")->groupBy('star')->get();
        $Average=Rating::selectRaw("CAST(AVG (star) AS DECIMAL (10,1)) as avg")->get();
        foreach($Average as $row){
            $avg[]=$row->avg;
            $AverageStr=implode(",",$avg);
        }
        foreach($ratings as $row){
            $rates[]=$row->totalstar;
            $ratesStr=implode(",",$rates);
        }

       // dd($count);
      return view('admin.dashboard', compact('maxRating','AverageStr','ratesStr','userImage','userFname','userLname','countEmployee','MonthlySalesStr','monthNameStr','yearlySalesStr','yearNameStr'));

    }
    public function showMenuListByDate(Request $request){
       $from = $request->from;
       $to = $request->to;

       $lists = DB::table('order_details')
                    ->whereBetween('created_at',[$from,$to])->get();

        return response()->json([
            'lists' => $lists
        ]);
    }
    public function setApriori(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        return view('pages.apriorisettings',compact('userImage','userFname','userLname'));
    }
    public function saveAprioriSettings(Request $request){
        try{
            $apriori=$this->customExceptions->AprioriException($request);
           
                }
                catch(\PDOException $e){
                    return back()->withError($e->getMessage())->withInput();
                }
    $aprSettings=new AprioriSettings();
    $checkdb=DB::table('bundle_menus')->get();
    if($checkdb==NULL){
    $aprSettings->support=$request->support;
    $aprSettings->confidence=$request->confidence;
    }
    else{
        $aprSettings->truncate();
        $aprSettings->support=$request->support;
        $aprSettings->confidence=$request->confidence;
    }
    $aprSettings->save();
    return redirect('/dashboard')->with('success',' Support and Confidence Successfully updated');
    }
    // public function getMenuCategoryID(){
    //     $menuCatID=DB::table('menus')->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
    //     ->select('menus.menuID','sub_categories.subcatid','sub_categories.categoryid')
    //     ->get();
    //     return $menuCatID;
    // }
    // public function ui(){
    //     $user = Auth::user();
    //     $userFname=$user->empfirstname;
    //     $userLname=$user->emplastname;
    //     return view('users.forgotpassword',compact('userFname','userLname'));
    // }
}
