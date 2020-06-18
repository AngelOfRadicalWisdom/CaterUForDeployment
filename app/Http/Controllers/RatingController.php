<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rating;
use Illuminate\Support\Facades\Auth;
use DB;
class RatingController extends Controller
{
    
    public function rate(Request $request){
        $rate = new Rating();
        $rate->star = $request->star;
        $rate->save();

        return response()->json([
            'message' => 'Thank you!'
        ]);
    }

    public function getStarCount(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
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
        //dd($ratesStr);
        return view('ratings.ratings',compact('userFname','userLname','userImage','ratesStr','maxRating','AverageStr'));
    }
    public function getStarSum(){
        $stars = DB::table('ratings')
                
               // ->groupBy('star')
                ->count('star');
        return response()->json([
            $stars
        ]);
    }
}
