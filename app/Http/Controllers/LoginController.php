<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\AppSettings;
use App\Employee;
use App\Session;
class LoginController extends Controller
{
    public $successStatus = 200;
    protected $redirectTo= '/login';

    public function __construct(Session $session){
        $this->session = $session;
    }

    public function username(){
        return 'username';
    }

    public function login(Request $request){
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;

            if(Auth::user()->position == 'waiter'){
               //print_r($request->session()->get('id',$user->username));
              // print_r($request->session()->get(Auth::user()->id));
            }
           return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }
    public function loginWeb(Request $request){
       // return back()->withError('error','Error Login')->withInput();
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;

            if(Auth::user()->position == 'admin'){
             return redirect('/dashboard')->with('success','Login Success');
            }
            else{
                return redirect('/employeedashboard')->with('success','Login Success');
            }
        }
        else{
            return redirect('/login')->with('error','Username or Password does not match');
        }
      
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->flush();
            return redirect()->to(url('/login'));
     }
    public function loginQR(){


    }
   





}
