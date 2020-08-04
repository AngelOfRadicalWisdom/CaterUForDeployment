<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeTime;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use App\Exceptions\CustomExceptions;
use Illuminate\Contracts\Validation\Validator;
class EmployeeController extends Controller
{
    private $customExceptions;
    public function __construct(CustomExceptions $customExceptions)
  {
      $this->customExceptions = $customExceptions;
  }
  public function employeeDashboard(){
    $user = Auth::user();
    $userFname=$user->empfirstname;
    $userLname=$user->emplastname;
    $userImage=$user->image;
    return view('admin.employeewelcome',compact('userFname','userLname','userImage'))->with('success','Login Success');
}
    public function employeeList(){
        $lists = Employee::all();
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        return view('employees.employeelist',compact('lists','userFname','userLname','userImage'));
    }
    public function newEmployee(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;

        return view('employees.addemployee', compact('userImage','userFname','userLname'));
    }
    public function saveNewEmployee(Request $request){
        $user = new Employee();
        // $this->validate(request(), [
        //     'empfirstname' => 'required',
        //     'emplastname'  => 'required',
        //     'username'  => 'required|unique:employees',
        //     'position'  => 'required',
        //     'password'  => 'required'

        // ]);
        try{
            $promo=$this->customExceptions->addEmployee($request);
          }
          catch(\PDOException $e){
            return back()->withError($e->getMessage())->withInput();
          }
       
        if($request->file('image')==NULL){
            $filename = 'CaterU.png';
         $user->empfirstname = $request->empfirstname;
        $user->emplastname  = $request->emplastname;
        $user->username = $request->username;
        $user->position = $request->position;
        $user->password = bcrypt($request->password);
        $user->image=$filename;
        $user->save();

       // auth()->login($user);

    }
    else{
        $filename = $request->file('image')->getClientOriginalName();

        $path = public_path().'/employee/employee_images';
        $request->file('image')->move($path, $filename);
        $user->empfirstname = $request->empfirstname;
        $user->emplastname  = $request->emplastname;
        $user->username = $request->username;
        $user->position = $request->position;
        $user->password = bcrypt($request->password);
        $user->image=$filename;
        $user->save();
        auth()->login($user);
        
}
return redirect('/employee/employeelist')->with('success','Employee Successfully Added');

}

public function updateEmployee($empid){
    $user = Auth::user();
    $userFname=$user->empfirstname;
    $userLname=$user->emplastname;
    $userImage=$user->image;
    $employeeRecord = Employee::find($empid); 
    return view('employees.updateEmployee', compact('userImage','userFname','userLname','employeeRecord'));
}
public function saveEmployeeUpdate($empid,Request $request)
{
    $employeeRecord = Employee::find($empid);
//     $this->validate(request(), [
//         'empfirstname' => 'required',
//         'emplastname'  => 'required',
//         'position'  => 'required',
//  ]);
try{
    $employee=$this->customExceptions->editEmployee($request,$empid);
  }
  catch(\PDOException $e){
    return back()->withError($e->getMessage())->withInput();
  }

    if($request->file('image')==NULL){
        $employeeRecord->empfirstname = $request->empfirstname;
        $employeeRecord->emplastname  = $request->emplastname;
        $employeeRecord->position = $request->position;
        $employeeRecord->username = $request->username;
        $employeeRecord->image=$employeeRecord->image;
        $employeeRecord->save();
    }
    else{
    $filename = $request->file('image')->getClientOriginalName();

    $path = public_path().'/employee/employee_images';
    $request->file('image')->move($path, $filename);

    $employeeRecord->empfirstname = $request->empfirstname;
        $employeeRecord->emplastname  = $request->emplastname;
        $employeeRecord->position = $request->position;
        $employeeRecord->username = $request->username;
        $employeeRecord->image=$filename;
        $employeeRecord->save();

    }
    return redirect('/employee/employeelist')->with('success','Employee Successfully Edited');
}
public function removeEmployee($empid)
{
    $employeeRecord = Employee::find($empid);

    if ($employeeRecord) {
        $employeeRecord->delete();
    }

    return \Response::json(['status' =>200,'error'=>""]);
}
public function ResetEmpPass(){
    $user = Auth::user();
    $userFname=$user->empfirstname;
    $userLname=$user->emplastname;
    $userImage=$user->image;
    return view('users.forgotpassword', compact('userFname','userLname','userImage'));

}
public function saveResetEmpPass(Request $request,$empid){
    $employeeRecord = Employee::find($empid);
        $employeeRecord->password=bcrypt($request->password);
        $employeeRecord->save();
        return redirect('/employee/employeelist')->with('success','Password resetted successfully');

}
//API
public function getEmpID($id){
    $id = Employee::find($id)->get();

    return response()->json([
        'id' => $id
    ]);
}
public function getEmpName($username){
    $data = array();
    $ids = DB::table('employees')->select('empfirstname')->where('username',$username)->get();

//     if($ids != NULL){
//         foreach($ids as $id){
//             array_push($data,array(
//                 'name' => $id->empfirstname
//             ));
//     }

// }
    return response()->json([
        'data' => $ids
    ]);
}

public function getPosition($username){
$position = DB::table('employees')
            ->select('position')
            ->where('username',$username)
            ->get();
return response()->json([
    'position' => $position
]);
}
public function timein(){
    $user = Auth::user();
    $userFname=$user->empfirstname;
    $userLname=$user->emplastname;
    $userImage=$user->image;
    $timein=new EmployeeTime();
    try{
        $employeeTime=$this->customExceptions->DuplicateTimeInException($user->empid);
       
            }
            catch(\PDOException $e){
                return back()->withError($e->getMessage())->withInput();
            }
            catch(\Exception $e){
                return back()->withError('Something Went Wrong')->withInput();
            }
    $timein->timein=Carbon::now();
    $timein->user_id=$user->empid;
    $timein->timeout=NULL;
    $timein->save();
    //dd(Carbon::now());
  // return view('admin.employeewelcome',compact('userFname','userLname','userImage'))->with('success','Timein Success');
    return redirect('/employeedashboard')->with('success','Timein Success');

}
public function timeout(){
    $user = Auth::user();
    $userFname=$user->empfirstname;
    $userLname=$user->emplastname;
    $userImage=$user->image;
    try{
        $employeeTime=$this->customExceptions->NoTimeinRecordException($user->empid);
       
            }
            catch(\PDOException $e){
                return back()->withError($e->getMessage())->withInput();
            }
            catch(\Exception $e){
                return back()->withError('Something Went Wrong')->withInput();
            }
            $timeout=EmployeeTime::whereDate('timein', '=', Carbon::today()->toDateString())->where('user_id',$user->empid)->update(['timeout' => Carbon::now()]);
            return redirect('/employeedashboard')->with('success','Timeout Success');
    
}


    }
