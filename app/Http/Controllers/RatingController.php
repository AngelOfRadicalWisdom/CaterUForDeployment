<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rating;
use Illuminate\Support\Facades\Auth;
use DB;

class RatingController extends Controller
{
    //mobile customer rate
    public function rate(Request $request)
    {
        $rate = new Rating();
        $rate->star = $request->star;
        $rate->save();

        return response()->json([
            'message' => 'Thank you!'
        ]);
    }
    //get the star count
    public function getStarCount()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $maxRating = 5;
        $ratesStr="";
        $ratings = Rating::selectRaw("Count(star) as totalstar,star")->groupBy('star')->get();
        $Average = Rating::selectRaw("CAST(AVG (star) AS DECIMAL (10,1)) as avg")->get();
        foreach ($Average as $row) {
            $avg[] = $row->avg;
            $AverageStr = implode(",", $avg);
        }
        foreach ($ratings as $row) {
            $rates[] = $row->totalstar;
            $ratesStr = implode(",", $rates);
        }

        return view('ratings.ratings', compact('userFname', 'userLname', 'userImage', 'ratesStr', 'maxRating', 'AverageStr'));
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong")->withInput();
    }
    }
    public function getStarSum()
    {
        try{
        $stars = DB::table('ratings')
            ->count('star');
        return response()->json([
            $stars
        ]);
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong")->withInput();
    }
}

}
