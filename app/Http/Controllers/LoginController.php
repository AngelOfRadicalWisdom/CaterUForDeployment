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
    protected $redirectTo = '/login';
    //session initialization
    public function __construct(Session $session)
    {
        $this->session = $session;
    }
    //landing page
    public function landingpage()
    {
        return view('create');
    }
    //username
    public function username()
    {
        return 'username';
    }
    // mobile login
    public function login(Request $request)
    {
        if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['id'] = $user->empid;
            $success['name'] = $user->empfirstname;
            $success['username'] = $user->username;
            $success['position'] = $user->position;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    //admin login
    public function loginWeb(Request $request)
    {
        if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;


            if (Auth::user()->position == 'admin') {
                return redirect('/dashboard')->with('success', 'Login Success');
            } else {
                return redirect('/employeedashboard')->with('success', 'Login Success');
            }
        } else {
            return redirect('/login')->with('error', 'Username or Password does not match');
        }
    }
    //logout function
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->to(url('/login'));
    }
}
