<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomExceptions;
use DB;
use QrCode;
use Carbon\Carbon;
use App\Employee;
use App\Log;
use Illuminate\Support\Facades\Auth;

class QRController extends Controller
{
    private $customExceptions;

    public function __construct(CustomExceptions $customExceptions)
    {
        $this->customExceptions = $customExceptions;
    }
    public function generateQR(Request $request)
    {
        $qrID=" ";
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $emp_info =  DB::table('employees')
            ->select('empid', 'emplastname', 'empfirstname')
            ->where('emplastname', $request->lastname)
            ->where('empfirstname', $request->firstname)
            ->get();
        foreach($emp_info as $emp){
        $qrID=$emp->empid;
        $qrID=(string)$qrID;
        }


        if ($emp_info != NULL) {
            // dd($employeename);
            \QrCode::size(500)
                ->format('png')
                ->generate('https://cateru.zenithdevgroup.me', public_path('/images/qrcode.png'));
            return view('qrCode', compact('userImage', 'userFname', 'userLname', 'emp_info','qrID'));
        }
        return view('qrCode', compact('userImage', 'userFname', 'userLname', 'emp_info','qrID'));
    }
    public function saveLog(Request $request)
    {
        $dLogs = DB::table('sessions')->where('user_id', $request->user_id)->get();

        foreach ($ids as $id) {
            $logs = new Log;
            $logs->username = $dLogs->username;
            $logs->tableno = $request->tableno;
            $logs->session_id = $dLogs->id;
            $logs->save();
        }

        return response()->json([
            'message' => 'Success!'
        ]);
    }
    public function readQR($id)
    {
        $employee_info = [];
        $ids = DB::table('employeetime')->where('user_id',$id)->count();

        if ($ids != 0) {
            $employee = Employee::find($id);

            array_push($employee_info, array(
                'emp_id'  => $employee->empid,
                'emp_name' => $employee->empfirstname,
                'emp_pos' => $employee->position
            ));

            return response()->json([
                'employee_info' => $employee_info
            ]);
        }
    }
}