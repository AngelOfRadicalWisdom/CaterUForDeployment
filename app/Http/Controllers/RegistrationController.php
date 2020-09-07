<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\AppSettings;
use App\Exceptions\CustomExceptions;
use App\Employee;

class RegistrationController extends Controller
{
    private $customExceptions;

    public function __construct(CustomExceptions $customExceptions)
    {
        //exception initialization
        $this->customExceptions = $customExceptions;
    }
    //create new user
    public function create()
    {
        return view('users.createprofile');
    }
    //save new user
    public function store(Request $request)
    {
        $user = new Employee;
        try {
            $employee = $this->customExceptions->registrationException($request);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        } catch (\Exception $e) {
            return back()->withError('Something Went Wrong')->withInput();
        }
        if ($request->file('image') == NULL) {
            $filename = 'CaterU.png';
            $password = bcrypt($request->password);
            $user->empfirstname = $request->empfirstname;
            $user->emplastname  = $request->emplastname;
            $user->username = $request->username;
            $user->position = $request->position;
            $user->password = bcrypt($request->password);
            $user->image = $filename;
            $user->save();
        } else {
            $this->validate($request, 

            [   'image' => 'image|mimes:jpeg,png,jpg,gif,svg',],
            ['image.image'=> 'Menu Image must be an image file type']
    
        );
            $filename = $request->file('image')->getClientOriginalName();

            $path = public_path() . '/employee/employee_images';
            $request->file('image')->move($path, $filename);
            $password = bcrypt($request->password);
            $user->empfirstname = $request->empfirstname;
            $user->emplastname  = $request->emplastname;
            $user->username = $request->username;
            $user->position = $request->position;
            $user->password = bcrypt($request->password);
            $user->image = $filename;
            $user->save();
        }
        return redirect()->to('/login')->with('success', 'Successfully Registered');
    }
}
