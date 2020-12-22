<?php

namespace App\Http\Controllers;

use App\Events\AprioriProcessEvent;
use App\Helper\AprioriNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Menu;
use Illuminate\Support\Facades\DB;
use App\OrderDetail;
use App\Kitchen;
class AprioriC2Controller extends Controller
{
    public function analyzation(){
      //  $user = Auth::user();
        // $userFname = $user->empfirstname;
        // $userLname = $user->emplastname;
        // $userImage = $user->image;
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
     //  $pairs=$apriori->apriori();
       $pairs=$apriori->support([3,5,2,20]);
      // $confidence=$apriori->confidence([3,5,2,20]);
     //    $pairs=$apriori->do_predict([2]);
    //      $menu = [];
    //    $groupedData = [];

    //    $transactions = DB::table('menus')
    //        ->selectRaw('group_concat(menus.name) as name')
    //        ->selectRaw('group_concat(menus.menuID) as menuID')
    //        ->selectRaw('group_concat(menus.image) as image')
    //        ->selectRaw('group_concat(menus.details) as details')
    //        ->selectRaw('group_concat(menus.servingsize) as servingsize')
    //        ->selectRaw('group_concat(menus.price) as price')
    //        ->selectRaw('group_concat(menus.subcatid) as subcatid')
    //        ->whereIn('menuID', $pairs)
    //        ->get();
    //        foreach ($transactions as $row) {
    //         $menu[] = explode(",", $row->menuID);
    //     }
    //     for ($index = 0; $index < count($menu); $index++) {
    //         foreach ($menu[$index] as $Smenus) {
    //             if ($Smenus != 12) {
    //                 $groupedData[] = $Smenus;
    //             }
    //         }
    //     }
    //     $final = array_unique($groupedData);
    //     $groupedData = [];
    //     $data;
    //     foreach ($final as $row) {
    //         $data = DB::table('menus')->where('menuID', $row)->get();
    //         array_push($groupedData, $row);
    //     }
    //     $data = [];
    //     for ($i = 0; $i < count($groupedData); $i++) {
    //         $t = DB::table('menus')->where('menuID', $groupedData[$i])->get();
 
    //         foreach ($t as $a) {
    //             array_push($data, array(
    //                 'name' => $a->name,
    //                 'menuID' => $a->menuID,
    //                 'image' => asset('/menu/menu_images/'.$a->image),
    //                 'details' => $a->details,
    //                 'price'=> $a->price,
    //                 'servingsize' => $a->servingsize,
    //                 'subcatid'=> $a->subcatid
    //             ));
    //         }
    //     }
    //        //dd($groupedData);
    //       $this->parr($data);
    // }
    // $allMenus=Menu::all();
    // foreach($allMenus as $menus){
    //     $recommended=array($apriori->do_predict([$menus->menuID]));
    //     foreach($recommended as $row){
    //     $transactions[] = DB::table('menus')
    //            ->selectRaw('name')
    //            ->whereIn('menuID', $row)
    //            ->get();
 
    // }
    
    // }
    // dd($transactions);
    // $allMenus = Menu::all();
    // foreach($allMenus as $menus){
    // $salesperMenu[]=DB::table('order_details')
    // ->selectRaw("sum(subtotal) as total")
    // ->where('menuID',$menus->menuID)
    // ->get();
    // }

    // dd($salesperMenu);
    $this->parr($pairs);
    
}
    private function parr($arr) {
        echo "<pre>";
        print_r(json_encode($arr));
        echo "</pre>";
    }
//public function analyzation(){
    // $orderDetails = OrderDetail::whereId(4)->first();
    // $kitchen=Kitchen::where('order_id',$orderDetails->order_id)->where('menuID',$orderDetails->menuID)->where('bundleid',$orderDetails->bundleid)->first();
    // $status = '';
    //     $servedQty = OrderDetail::whereId(4)->pluck('qtyServed')->first();
    //     if ($servedQty === 0) {
    //         $detail = OrderDetail::find('4');
    //         $detail->status = 'served';
    //         $detail->save();
    //         $status = 'Order is served.';
    //         $kitchen->status= 'served';
    //         $kitchen->save();
    //     } else {
    //         $status = 'Orders is being prepared.';
    //     }
//     $status = '';
//     $id= 4;
//         $servedQty = OrderDetail::whereId($id)->pluck('qtyServed')->first();
//         $orderDetails = OrderDetail::whereId(4)->first();
//         $kitchen=Kitchen::where('order_id',$orderDetails->order_id)->where('menuID',$orderDetails->menuID)->where('bundleid',$orderDetails->bundleid)->first();
//         if ($servedQty === NULL) {
//             $detail =OrderDetail::find($id);
//             $kitchenRecord=Kitchen::find($kitchen->id);
//             $detail->status ='served';
//             $kitchenRecord->status="served";
//             $kitchenRecord->save();
//             $detail->save();
//             $status = 'Order is served.';
//         } else {
//             $status = 'Orders is being prepared.';
//         }
// dd($kitchenRecord);
// }
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
    //showing recommended items
    public function showRecommendation(){
        try{
            $user = Auth::user();
            $userFname = $user->empfirstname;
            $userLname = $user->emplastname;
            $userImage = $user->image;
            $transactions=[];
            $menuID="";
            $menuName="";
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
        $allMenus=Menu::all();
        foreach($allMenus as $menus){
            $recommended=array($apriori->do_predict([$menus->menuID]));
            foreach($recommended as $row){
                $transactions[] = DB::table('menus')
                ->selectRaw('name')
                ->whereIn('menuID', $row)
                ->get();
        }
        foreach ($allMenus as $row) {
            $result[] = explode(',', $row->menuID);
            $mName[]=explode(',', $row->name);
        }
        foreach($transactions as $row){
            $rItems[] = explode(',', $row);
        }
        $menuID = array_values($result);
        $menuName=array_values($mName);
        }
        return view('pages.showrecommendation', compact('userImage', 'userFname', 'userLname', 'transactions','menuID','menuName','allMenus'));
      
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong")->withInput();
    }
    }
        

   //sending the recommendations to the mobile side
   public function sendApriori($menuId)
   {
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
  //  $pairs=$apriori->apriori();
    // $pairs=$apriori->getRules();
     $pairs=$apriori->do_predict([$menuId]);
     $menu = [];
   $groupedData = [];

   $transactions = DB::table('menus')
   ->selectRaw('group_concat(menus.name) as name')
   ->selectRaw('group_concat(menus.menuID) as menuID')
   ->selectRaw('group_concat(menus.image) as image')
   ->selectRaw('group_concat(menus.details) as details')
   ->selectRaw('group_concat(menus.servingsize) as servingsize')
   ->selectRaw('group_concat(menus.price) as price')
   ->selectRaw('group_concat(menus.subcatid) as subcatid')
   ->whereIn('menuID', $pairs)
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

   public function sendApriori2(Request $request)
   {
    $pairs = [];
    $transactions = [];
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
  //  $pairs=$apriori->apriori();
    // $pairs=$apriori->getRules();
    foreach($request->menu as $menu){
        array_push($pairs,$apriori->do_predict([$menu]));
    }
    //  $pairs=$apriori->do_predict([$request]);
     $menu = [];
   $groupedData = [];

   foreach($pairs as $pair){
    DB::table('menus')
       ->selectRaw('group_concat(menus.name) as name')
       ->selectRaw('group_concat(menus.menuID) as menuID')
       ->selectRaw('group_concat(menus.image) as image')
       ->selectRaw('group_concat(menus.details) as details')
       ->selectRaw('group_concat(menus.servingsize) as servingsize')
       ->selectRaw('group_concat(menus.price) as price')
       ->selectRaw('group_concat(menus.subcatid) as subcatid')
       ->whereIn('menuID', $pair)
       ->get();
   }
//    $transactions = DB::table('menus')
//    ->selectRaw('group_concat(menus.name) as name')
//    ->selectRaw('group_concat(menus.menuID) as menuID')
//    ->selectRaw('group_concat(menus.image) as image')
//    ->selectRaw('group_concat(menus.details) as details')
//    ->selectRaw('group_concat(menus.servingsize) as servingsize')
//    ->selectRaw('group_concat(menus.price) as price')
//    ->selectRaw('group_concat(menus.subcatid) as subcatid')
//    ->whereIn('menuID', $pairs)
//    ->get();
       foreach ($transactions as $row) {
        $menu[] = explode(",", $row->menuID);
    }
    for ($index = 0; $index < count($menu); $index++) {
        foreach ($menu[$index] as $Smenus) {
            if ($Smenus != $request->menuID) {
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
       return response()->json(['menu' => $request->menu]);

   }


}