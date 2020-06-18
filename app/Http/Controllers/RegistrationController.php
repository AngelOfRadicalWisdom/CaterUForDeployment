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
        $this->customExceptions = $customExceptions;
    }
    public function create(){
        return view('users.createprofile');
    }

    public function store(Request $request)
    {
         $user = new Employee;
        // $this->validate(request(), [
        //     'empfirstname' => 'required',
        //     'emplastname'  => 'required',
        //     'username'  => 'required|unique:employees',
        //     'position'  => 'required',
        //     'password'  => 'required'

        // ]);
        try{
            $employee=$this->customExceptions->registrationException($request);
           
                }
                catch(\PDOException $e){
                    return back()->withError($e->getMessage())->withInput();
                }
                catch(\Exception $e){
                    return back()->withError('Something Went Wrong')->withInput();
                }
        if($request->file('image')==NULL){
            $filename='CaterU.png';
        $password = bcrypt($request->password);
         $user->empfirstname = $request->empfirstname;
        $user->emplastname  = $request->emplastname;
        $user->username = $request->username;
        $user->position = $request->position;
        $user->password = bcrypt($request->password);
        $user->image=$filename;
        $user->save();

     //   auth()->login($user);

      
    }
    else{
        $filename = $request->file('image')->getClientOriginalName();

        $path = public_path().'/employee/employee_images';
        $request->file('image')->move($path, $filename);
        $password = bcrypt($request->password);
        $user->empfirstname = $request->empfirstname;
        $user->emplastname  = $request->emplastname;
        $user->username = $request->username;
        $user->position = $request->position;
        $user->password = bcrypt($request->password);
        $user->image=$filename;
        $user->save();
       // auth()->login($user);
        
}
return redirect()->to('/login')->with('success','Successfully Registered');

}
}
