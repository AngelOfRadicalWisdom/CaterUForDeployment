<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
   public function getSessionUserId(Request $request)
   {
      // return DB::table('sessions')->where('user_id',$request->id)->get();
      //return Session::get($request->payload);
      // return session(['id' => $request->user_id]);

      // Session::put('id',$request->user_id);
      // return $request->session()->forget('id','2');

      if ($request->session()->has(1))
         return $request->session()->get(1);
      else
         return 'No data';
   }

   public function accessSessionData(Request $request, $id)
   {
      if ($request->session()->has($id))
         return $request->session()->get($id);
      else
         return 'No data in the session';
   }
   public function storeSessionData(Request $request)
   {
      $request->session()->put('my_name', 'Virat Gandhi');
      echo "Data has been added to session";
   }
   public function deleteSessionData(Request $request)
   {
      $request->session()->forget('my_name');
      echo "Data has been removed from session.";
   }
}
