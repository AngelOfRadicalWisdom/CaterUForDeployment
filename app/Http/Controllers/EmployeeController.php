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
    //exception initialization
    private $customExceptions;
    public function __construct(CustomExceptions $customExceptions)
    {
        $this->customExceptions = $customExceptions;
    }
    //employee welcome screen
    public function employeeDashboard()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        return view('admin.employeewelcome', compact('userFname', 'userLname', 'userImage'))->with('success', 'Login Success');
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    }
    //list of employees
    public function employeeList()
    {
        try{
        $lists = Employee::all();
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        return view('employees.employeelist', compact('lists', 'userFname', 'userLname', 'userImage'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    }
    //add a new employee
    public function newEmployee()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;

        return view('employees.addemployee', compact('userImage', 'userFname', 'userLname'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    }
    //save the new employee to database 
    public function saveNewEmployee(Request $request)
    {
        $this->validate($request, 

        [   'image' => 'image|mimes:jpeg,png,jpg,gif,svg',],
        ['image.image'=> 'Menu Image must be an image file type']

    );
        $user = new Employee();
        try {
            $promo = $this->customExceptions->addEmployee($request);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
try{
        if ($request->file('image') == NULL) {
            $filename = 'CaterU.png';
            $user->empfirstname = $request->empfirstname;
            $user->emplastname  = $request->emplastname;
            $user->username = $request->username;
            $user->position = $request->position;
            $user->password = bcrypt($request->password);
            $user->image = $filename;
            $user->save();
        } else {
            $filename = $request->file('image')->getClientOriginalName();

            $path = public_path() . '/employee/employee_images';
            $request->file('image')->move($path, $filename);
            $user->empfirstname = $request->empfirstname;
            $user->emplastname  = $request->emplastname;
            $user->username = $request->username;
            $user->position = $request->position;
            $user->password = bcrypt($request->password);
            $user->image = $filename;
            $user->save();
        }
        return redirect('/employee/employeelist')->with('success', 'Employee Successfully Added');
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
    }
    }
    //update employee screen
    public function updateEmployee($empid)
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $employeeRecord = Employee::find($empid);
        return view('employees.updateEmployee', compact('userImage', 'userFname', 'userLname', 'employeeRecord'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    }
    //save updated employee information
    public function saveEmployeeUpdate($empid, Request $request)
    {
        try{
        $employeeRecord = Employee::find($empid);
        try {
            $employee = $this->customExceptions->editEmployee($request, $empid);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        if ($request->file('image') == NULL) {
            $employeeRecord->empfirstname = $request->empfirstname;
            $employeeRecord->emplastname  = $request->emplastname;
            $employeeRecord->position = $request->position;
            $employeeRecord->username = $request->username;
            $employeeRecord->image = $employeeRecord->image;
            $employeeRecord->save();
        } else {
            $this->validate($request, 

            [   'image' => 'image|mimes:jpeg,png,jpg,gif,svg',],
            ['image.image'=> 'Menu Image must be an image file type']
    
        );
            $filename = $request->file('image')->getClientOriginalName();

            $path = public_path() . '/employee/employee_images';
            $request->file('image')->move($path, $filename);

            $employeeRecord->empfirstname = $request->empfirstname;
            $employeeRecord->emplastname  = $request->emplastname;
            $employeeRecord->position = $request->position;
            $employeeRecord->username = $request->username;
            $employeeRecord->image = $filename;
            $employeeRecord->save();
        }
        return redirect('/employee/employeelist')->with('success', 'Employee Successfully Edited');
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
        }
    }
    //remove employee from list
    public function removeEmployee($empid)
    {
        try{
        $employeeRecord = Employee::find($empid);

        if ($employeeRecord) {
            $employeeRecord->delete();
        }

        return \Response::json(['status' => 200, 'error' => ""]);
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
    }
    }
    //reset employee password screen
    public function ResetEmpPass()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        return view('users.forgotpassword', compact('userFname', 'userLname', 'userImage'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    }
    //save new passsword 
    public function saveResetEmpPass(Request $request, $empid)
    {
        try{
        $employeeRecord = Employee::find($empid);
        $employeeRecord->password = bcrypt($request->password);
        $employeeRecord->save();
        return redirect('/employee/employeelist')->with('success', 'Password resetted successfully');
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
        }
    }
    //API Mobile
    //get employee ID 
    public function getEmpID($id)
    {
        $id = Employee::find($id)->get();

        return response()->json([
            'id' => $id
        ]);
    }
    //get employee name
    public function getEmpName($username)
    {
        $data = array();
        $ids = DB::table('employees')->select('empfirstname')->where('username', $username)->get();
        return response()->json([
            'data' => $ids
        ]);
    }
    //get employee position
    public function getPosition($username)
    {
        $position = DB::table('employees')
            ->select('position')
            ->where('username', $username)
            ->get();
        return response()->json([
            'position' => $position
        ]);
    }
    //employee time in
    public function timein()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $timein = new EmployeeTime();
        try {
            $employeeTime = $this->customExceptions->DuplicateTimeInException($user->empid);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        } catch (\Exception $e) {
            return back()->withError('Something Went Wrong')->withInput();
        }
    //    $timein->timein = Carbon::now('Asia/Singapore');
        $timein->timein = Carbon::now();
        $timein->user_id = $user->empid;
        $timein->timeout = NULL;
        $timein->save();
        return redirect('/employeedashboard')->with('success', 'Timein Success');
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong")->withInput();
    }
    }
    //employee timeout
    public function timeout()
    {
        try{
        $user = Auth::user();
        $date = Carbon::today('Asia/Singapore')->toDateString();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        try {
            $employeeTime = $this->customExceptions->NoTimeinRecordException($user->empid);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        } catch (\Exception $e) {
            return back()->withError('Something Went Wrong')->withInput();
        }
        // $timeout = EmployeeTime::whereDate('timein', '=', Carbon::today('Asia/Singapore')->toDateString())->where('user_id', $user->empid)->update(['timeout' => Carbon::now('Asia/Singapore')]);
        // return redirect('/employeedashboard')->with('success', 'Timeout Success');
        $timeout = EmployeeTime::whereDate('timein', '=', Carbon::today('Asia/Singapore')->toDateString())->where('user_id', $user->empid)->update(['timeout' => Carbon::now()]);
        return redirect('/employeedashboard')->with('success', 'Timeout Success');
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong")->withInput();
    }
}
}
