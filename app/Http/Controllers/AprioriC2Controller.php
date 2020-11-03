<?php

namespace App\Http\Controllers;

use App\Events\AprioriProcessEvent;
use App\Helper\AprioriNew;
use Illuminate\Support\Facades\Auth;
use App\Menu;
use Illuminate\Support\Facades\DB;

class AprioriC2Controller extends Controller
{
    //generating apriori page
    public function generateAprioriPage()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $samples = $this->getTransactions();
        $sc = $this->getSupportandConfidence();
        if (count($sc) == 0) {
            $support = '';
            $confidence = '';
            $support = 75 / 100;
            $confidence = 75 / 100;
        } else {
            $support = '';
            $confidence = '';
            foreach ($sc as $row) {
                $support = $row->support / 100;
                $confidence = $row->confidence / 100;
            }
        }
        $apriori = new AprioriNew($samples, $support, $confidence);
        $allMenus = Menu::all();
        $ItemSets = DB::table('apriori')
            ->selectRaw('COUNT(menuID) as count')
            ->groupBy('groupNumber')
            ->distinct()
            ->get();
        $suggestedMenus = DB::table('apriori')
            ->join('menus', 'apriori.menuID', '=', 'menus.menuID')
            ->selectRaw('group_concat(menus.menuID) as menuID')
            ->groupBy('apriori.groupNumber')
            ->get();
        $result = [];
        foreach ($suggestedMenus as $row) {
            $result[] = explode(',', $row->menuID);
        }
        $sMenus = array_values($result);
        $count = DB::table('apriori')
            ->selectRaw('group_concat(menuID) as menuID')
            ->groupBy('apriori.groupNumber')
            ->get();
        if (count($count) == 0) {
            $frequentCount = 0;
            return view('admin.generateApriori', compact('frequentCount', 'userImage', 'userFname', 'userLname', 'allMenus', 'sMenus', 'ItemSets'));
        } else {
            foreach ($count as $pairingCount) {
                $frequentMenus[] = explode(',', $pairingCount->menuID);
                for ($i = 0; $i < count($frequentMenus); $i++) {
                    $frequentCount[] = $apriori->frequency($frequentMenus[$i]);
                }
            }

            return view('admin.generateApriori', compact('frequentCount', 'userImage', 'userFname', 'userLname', 'allMenus', 'sMenus', 'ItemSets'));
        }
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong")->withInput();
    }
    }
    //adding the generated pairs to database
    public function addPairs()
    {
        try{
        event(new AprioriProcessEvent());
        return redirect('/dashboard')->with('success', 'Your recommendations are being processed');;
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
    }
    }
   
    //getting all of the transactions
    private function getTransactions()
    {
        try{
        $transactions = DB::table('order_details')
            ->select(DB::raw('group_concat(menuID) as transaction'))
            ->groupBy('order_id')
            ->orderBy('order_id')
            ->get();
        $result = [];
        foreach ($transactions as $row) {
            $result[] = explode(',', $row->transaction);
        }
        return array_values($result);
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
    }
    }
    //getting the support and confidence
    private function getSupportandConfidence()
    {
        $sc = DB::table('aprioriSettings')->get();
        return $sc;
    }
   //sending the recommendations to the mobile side
   public function sendApriori($menuId)
   {
       $menu = [];
       $groupedData = [];

       $transactions = DB::table('apriori')
           ->join('menus', 'apriori.menuID', '=', 'menus.menuID')
           ->selectRaw('group_concat(menus.name) as name')
           ->selectRaw('group_concat(menus.menuID) as menuID')
           ->selectRaw('group_concat(menus.image) as image')
           ->selectRaw('group_concat(menus.details) as details')
           ->selectRaw('group_concat(menus.servingsize) as servingsize')
           ->selectRaw('group_concat(menus.price) as price')
           ->selectRaw('group_concat(menus.subcatid) as subcatid')
           ->groupBy('apriori.groupNumber')
           ->havingRaw('menuID', [$menuId])
           ->get();


       foreach ($transactions as $row) {
           $menu[] = explode(",", $row->menuID);
       }
       for ($index = 0; $index < count($menu); $index++) {
           foreach ($menu[$index] as $Smenus) {
               if ($Smenus != $menuId) {
                   $groupedData[] = $Smenus;
               }
           }
       }
       $final = array_unique($groupedData);
       $groupedData = [];
       $data;
       foreach ($final as $row) {
           $data = DB::table('menus')->where('menuID', $row)->get();
           array_push($groupedData, $row);
       }
       $data = [];
       for ($i = 0; $i < count($groupedData); $i++) {
           $t = DB::table('menus')->where('menuID', $groupedData[$i])->get();

           foreach ($t as $a) {
               array_push($data, array(
                   'name' => $a->name,
                   'menuID' => $a->menuID,
                   'image' => asset('/menu/menu_images/'.$a->image),
                   'details' => $a->details,
                   'price'=> $a->price,
                   'servingsize' => $a->servingsize,
                   'subcatid'=> $a->subcatid
               ));
           }
       }

       return response()->json(['menu' => $data]);
   }
}