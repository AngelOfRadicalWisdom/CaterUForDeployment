<?php

namespace App\Http\Controllers;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use App\Exceptions\CustomExceptions;
use Illuminate\Http\Request;
use App\Apriori;
use App\BundleMenu;
use App\BundleDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Menu;

class PromotionController extends Controller
{
  //exception initialization
  private $customExceptions;

  public function __construct(CustomExceptions $customExceptions)
  {
    $this->customExceptions = $customExceptions;
  }
  //create a new promo page
  public function createPromo(Request $request)
  {
    try{
    $user = Auth::user();
    $userFname = $user->empfirstname;
    $userLname = $user->emplastname;
    $userImage = $user->image;
    $currentPromo="";
    $cpromo="";
    $ItemSets = DB::table('apriori')
      ->selectRaw('COUNT(menuID) as count')
      ->groupBy('groupNumber')
      ->distinct()
      ->get();
    $allMenus = Menu::all();
    $suggestedMenus = DB::table('apriori')
      ->join('menus', 'apriori.menuID', '=', 'menus.menuID')
      ->selectRaw('group_concat(menus.menuID) as menuID')
      ->groupBy('apriori.groupNumber')
      ->get();
      $currentPromo= BundleMenu::orderBy('bundleid', 'DESC')->first();
      if($currentPromo==NULL){
         $cpromo=0;
      }
      else{      
        $cpromo=$currentPromo->bundleid;
      }
    $bestsellers = DB::table('apriori')->select('menuID')->distinct()->get();
    $bseller=[];
    foreach ($bestsellers as $row){
      $bseller[] = explode(',', $row->menuID);
    
    }
    $result = [];
    foreach ($suggestedMenus as $row) {
      $result[] = explode(',', $row->menuID);
    }
    $sMenus = array_values($result);
    $bsellermenus= array_values($bseller);
    $additionalMenus = DB::table('menus')
      ->whereNotIn('menuID', $bsellermenus)
      ->where('deleted_at','=',NULL)
      ->get();

    return view('admin.promo.addnewpromo', compact('cpromo','userFname', 'userLname', 'sMenus', 'allMenus', 'additionalMenus', 'ItemSets', 'userImage'));
    }
    catch (\PDOException $e) {
      return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
  }
  }
  //save the new promo to database
  public function savePromo(Request $request)
  {
    try{
    $bundledmenu = new BundleMenu();
    $allMenus = [];
    $allQuantity = [];
    $suggestedMenus = array_values(explode(',', $request->suggestedmenus));
    $additionalMenus = array_values(explode(',', $request->additionalmenus));
    $bundleQuantity = array_values(explode(',', $request->squantity));
    $additionalQuantity = array_values(explode(',', $request->aquantity));
    if ($request->squantity != NULL) {
      for ($j = 0; $j < count($bundleQuantity); $j++) {
        $allQuantity[] = $bundleQuantity[$j];
      }
    }
    if ($request->aquantity != NULL) {
      for ($j = 0; $j < count($additionalQuantity); $j++) {
        $allQuantity[] = $additionalQuantity[$j];
      }
    }
    if ($request->suggestedmenus != NULL) {
      for ($i = 0; $i < count($suggestedMenus); $i++) {
        $apriori = DB::table('apriori')->where('groupNumber', $suggestedMenus[$i])->get();
        foreach ($apriori as $menus) {
          $allMenus[] = $menus->menuID;
        }
      }
    }
    if ($request->additionalmenus != NULL) {
      for ($i = 0; $i < count($additionalMenus); $i++) {
        $additional = Menu::find($additionalMenus[$i]);
        $allMenus[] = $additional->menuID;
      }
    }
    try {
      $this->customExceptions->addPromoException($request, $allMenus, $suggestedMenus);
    } catch (\PDOException $e) {
      return \Response::json(['status' => 500, 'error' => $e->getMessage()]);
    }
    catch (QueryException $e) {
      return \Response::json(['status' => 500, 'error' => $e->getMessage()]);
    }
    catch (\Exception $e) {
      return \Response::json(['status' => 500, 'error' => $e->getMessage()]);
    }
    $filename = 'CaterU.png';
    if ($request->file('image') == NULL) {
      $bundledmenu->bundleid = $request->promoid;
      $bundledmenu->name = $request->promoname;
      $bundledmenu->price = $request->price;
      $bundledmenu->servingsize = $request->servingsize;
      $bundledmenu->details = $request->details;
      $bundledmenu->image = $filename;
      $bundledmenu->status=$request->status;
      $bundledmenu->save();

      for ($i = 0; $i < count($allMenus); $i++) {
        $menuRecord = Menu::find($allMenus[$i]);
        $quantity = $allQuantity[$i];
        $row = array('menuID' => $menuRecord->menuID, 'qty' => $quantity, 'bundleid' => $request->promoid);
        $this->addPromotionsRow($row);
      }
    } else {  
      $this->validate($request, 

        [   'image' => 'image|mimes:jpeg,png,jpg,gif,svg',],
        ['image.image'=> 'Menu Image must be an image file type']

    );
      $filename = $request->file('image')->getClientOriginalName();
      $path = public_path().'/promotions/promotions_images';
      $request->file('image')->move($path, $filename);
      $bundledmenu->bundleid = $request->promoid;
      $bundledmenu->name = $request->promoname;
      $bundledmenu->price = $request->price;
      $bundledmenu->servingsize = $request->servingsize;
      $bundledmenu->details = $request->details;
      $bundledmenu->image = $filename;
      $bundledmenu->status=$request->status;
      $bundledmenu->save();

      for ($i = 0; $i < count($allMenus); $i++) {
        $menuRecord = Menu::find($allMenus[$i]);
        $quantity = $allQuantity[$i];
        $row = array('menuID' => $menuRecord->menuID, 'qty' => $quantity, 'bundleid' => $request->promoid);
        $this->addPromotionsRow($row);
      }
    }
    return \Response::json(['status' => 200, 'error' => " "]);
  }
  catch (\PDOException $e) {
    return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
}
  }
  //insertion function
  private function addPromotionsRow($row)
  {
    DB::table('bundle_details')->insert($row);
  }
  //retrieve promo lists
  public function promotionsList()
  {
    try{
    $user = Auth::user();
    $userFname = $user->empfirstname;
    $userLname = $user->emplastname;
    $userImage = $user->image;
    $promotion = BundleMenu::all();
    $promotionDetails = BundleDetails::all();
    $allMenus = Menu::all();
    return view('admin.promo.promotionslist', compact('userImage', 'userFname', 'userLname', 'promotion', 'allMenus', 'promotionDetails'));
    }
    catch (\PDOException $e) {
      return back()->withError("Sorry Something Went Wrong")->withInput();
  }
  }
  //edit promo
  public function editPromo(Request $request, $bundleid)
  {
    try{
    $user = Auth::user();
    $userFname = $user->empfirstname;
    $userLname = $user->emplastname;
    $userImage = $user->image;
    $allMenus = Menu::all();
    if ($request->isMethod('post')) {
    }
    $promotion = BundleMenu::where(['bundleid' => $bundleid])->first();
    $promotionDetails = BundleDetails::where(['bundleid' => $bundleid])->get();
    return view('admin.promo.editpromo')->with(compact('allMenus', 'userImage', 'userFname', 'userLname', 'promotion', 'promotionDetails'));
    }
    catch (\PDOException $e) {
      return back()->withError("Sorry Something Went Wrong")->withInput();
  }
  }
  //save the edited promo to database
  public function saveEditPromo(Request $request, $bundleid)
  {
    try{
    try {
      $promo = $this->customExceptions->editPromoException($request,$bundleid);
    } catch (\PDOException $e) {
      return back()->withError($e->getMessage())->withInput();
    } catch (\Exception $e) {
      return back()->withError('Something Went Wrong')->withInput();
    }
    catch (QueryException $e) {
      return \Response::json(['status' => 500, 'error' => $e->getMessage()]);
    }
    $bundlemenu = BundleMenu::find($bundleid);
    if ($request->file('image') == NULL) {
      $filename = 'CaterU.png';
      $bundlemenu->price = $request->price;
      $bundlemenu->name = $request->promoname;
      $bundlemenu->servingsize = $request->servingsize;
      $bundlemenu->details = $request->details;
      $bundlemenu->image = $bundlemenu->image;
      if ($bundlemenu->image == NULL) {
        $bundlemenu->image = $filename;
      }
      $bundlemenu->save();
    } else {
      $this->validate($request, 

        [   'image' => 'image|mimes:jpeg,png,jpg,gif,svg',],
        ['image.image'=> 'Menu Image must be an image file type']

    );
      $filename = $request->file('image')->getClientOriginalName();
      $path = public_path() . '/promotions/promotions_images';
      $request->file('image')->move($path, $filename);
      $bundlemenu->price = $request->price;
      $bundlemenu->servingsize = $request->servingsize;
      $bundlemenu->details = $request->details;
      //previously bundle
      $bundlemenu->image = $request->image;
      $bundlemenu->save();
    }
    return redirect('/promo/promolist')->with('success', 'Promotion Information was edited');
  }
  catch (\PDOException $e) {
    return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
}
  }
  //adding promotion details
  public function addPromoDetails($bundleid)
  {
    try{
    $user = Auth::user();
    $userFname = $user->empfirstname;
    $userLname = $user->emplastname;
    $userImage = $user->image;
    $ItemSets = DB::table('apriori')
      ->selectRaw('COUNT(menuID) as count')
      ->groupBy('groupNumber')
      ->distinct()
      ->get();
    $promotion = BundleMenu::where(['bundleid' => $bundleid])->first();
    $promotionDetails = BundleDetails::where(['bundleid' => $bundleid])->get();
    $allMenus = Menu::all();
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
    $additionalMenus = DB::table('menus')
      ->whereNotIn('menuID', $sMenus)
      ->get();
    return view('admin.promo.addnewpromodetails')->with(compact('userImage', 'userFname', 'userLname', 'promotion', 'promotionDetails', 'allMenus', 'sMenus', 'additionalMenus', 'ItemSets'));
  }
  catch (\PDOException $e) {
    return back()->withError("Sorry Something Went Wrong")->withInput();
}
  }
  //save promotion details to database
  public function saveAddPromoDetails(Request $request)
  {
    try{
    $allMenus = [];
    $allQuantity = [];
    $suggestedMenus = array_values(explode(',', $request->suggestedmenus));
    $additionalMenus = array_values(explode(',', $request->additionalmenus));
    $bundleQuantity = array_values(explode(',', $request->squantity));
    $additionalQuantity = array_values(explode(',', $request->aquantity));
    if ($request->squantity != NULL) {
      for ($j = 0; $j < count($bundleQuantity); $j++) {
        $allQuantity[] = $bundleQuantity[$j];
      }
    }
    if ($request->aquantity != NULL) {
      for ($j = 0; $j < count($additionalQuantity); $j++) {
        $allQuantity[] = $additionalQuantity[$j];
      }
    }
    if ($request->suggestedmenus != NULL) {
      for ($i = 0; $i < count($suggestedMenus); $i++) {
        $apriori = DB::table('apriori')->where('groupNumber', $suggestedMenus[$i])->get();
        foreach ($apriori as $menus) {
          $allMenus[] = $menus->menuID;
        }
      }
    }
    if ($request->additionalmenus != NULL) {
      for ($i = 0; $i < count($additionalMenus); $i++) {
        $additional = Menu::find($additionalMenus[$i]);
        $allMenus[] = $additional->menuID;
      }
    }
    try {
      $promo = $this->customExceptions->addPromoMenuException($request, $allMenus, $suggestedMenus, $additionalMenus);
    } catch (\PDOException $e) {
      return \Response::json(['status' => 500, 'error' => $e->getMessage()]);
    }
    for ($i = 0; $i < count($allMenus); $i++) {
      $menuRecord = Menu::find($allMenus[$i]);
      $quantity = $allQuantity[$i];
      $row = array('menuID' => $menuRecord->menuID, 'qty' => $quantity, 'bundleid' => $request->promoid);
      $this->addPromotionsRow($row);
    }
    return \Response::json(['status' => 200, 'error' => ""]);
  }
  catch (\PDOException $e) {
    return back()->withError("Sorry Something Went Wrong")->withInput();
}
  }
  //edit promo details
  public function editPromoDetails(Request $request, $bundleid)
  {
    try{
    $user = Auth::user();
    $userFname = $user->empfirstname;
    $userLname = $user->emplastname;
    $userImage = $user->image;
    $promotion = BundleMenu::where(['bundleid' => $bundleid])->first();
    $promotionDetails = BundleDetails::where(['bundleid' => $bundleid])->get();
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
    $additionalMenus = DB::table('menus')
      ->whereNotIn('menuID', $sMenus)
      ->get();
    return view('admin.promo.editpromodetails')->with(compact('userImage', 'userFname', 'userLname', 'promotion', 'promotionDetails', 'allMenus', 'sMenus', 'additionalMenus', 'ItemSets'));
    }
    catch (\PDOException $e) {
      return back()->withError("Sorry Something Went Wrong")->withInput();
  }
  }
  //save updated promo details to database
  public function saveEditPromoDetails(Request $request)
  {
    try{
    $check = BundleDetails::where('bundleid', $request->bundleid)->get();
    $allMenus = [];
    $allQuantity = [];
    $suggestedMenus = array_values(explode(',', $request->suggestedmenus));
    $additionalMenus = array_values(explode(',', $request->additionalmenus));
    $bundleQuantity = array_values(explode(',', $request->squantity));
    $additionalQuantity = array_values(explode(',', $request->aquantity));
    if ($request->squantity != NULL) {
      for ($j = 0; $j < count($bundleQuantity); $j++) {
        $allQuantity[] = $bundleQuantity[$j];
      }
    }
    if ($request->aquantity != NULL) {
      for ($j = 0; $j < count($additionalQuantity); $j++) {
        $allQuantity[] = $additionalQuantity[$j];
      }
    }
    if ($check != NULL) {
      if ($request->suggestedmenus != NULL) {
        for ($i = 0; $i < count($suggestedMenus); $i++) {
          $apriori = DB::table('apriori')->where('groupNumber', $suggestedMenus[$i])->get();
          foreach ($apriori as $menus) {
            $allMenus[] = $menus->menuID;
          }
        }
      }
      if ($request->additionalmenus != NULL) {
        for ($i = 0; $i < count($additionalMenus); $i++) {
          $additional = Menu::find($additionalMenus[$i]);
          $allMenus[] = $additional->menuID;
        }
      }
      try {
        $promo = $this->customExceptions->EditPromoMenuException($request, $allMenus);
      } catch (\PDOException $e) {
        return \Response::json(['status' => 500, 'error' => $e->getMessage()]);
      } catch (\Exception $e) {
        return \Response::json(['status' => 500, 'error' => $e->getMessage()]);
      }
      BundleDetails::where('bundleid', $request->promoid)->delete();
      for ($i = 0; $i < count($allMenus); $i++) {
        $menuRecord = Menu::find($allMenus[$i]);
        $quantity = $allQuantity[$i];
        $row = array('menuID' => $menuRecord->menuID, 'qty' => $quantity, 'bundleid' => $request->promoid);
        $this->addPromotionsRow($row);
      }
    } else {
      if ($request->suggestedmenus != NULL) {
        for ($i = 0; $i < count($suggestedMenus); $i++) {
          $apriori = DB::table('apriori')->where('groupNumber', $suggestedMenus[$i])->get();
          foreach ($apriori as $menus) {
            $allMenus[] = $menus->menuID;
          }
        }
      }
      if ($request->additionalmenus != NULL) {
        for ($i = 0; $i < count($additionalMenus); $i++) {
          $additional = Menu::find($additionalMenus[$i]);
          $allMenus[] = $additional->menuID;
        }
      }
      for ($i = 0; $i < count($allMenus); $i++) {
        $menuRecord = Menu::find($allMenus[$i]);
        $quantity = $allQuantity[$i];
        $row = array('menuID' => $menuRecord->menuID, 'qty' => $quantity, 'bundleid' => $request->promoid);
        $this->addPromotionsRow($row);
      }
    }

    return \Response::json(['status' => 200]);
  }
  catch (\PDOException $e) {
    return back()->withError("Sorry Something Went Wrong")->withInput();
}
  }
  //delete promotion
  public function deletePromo($promoid)
  {
    try{
    $bundleMenu = BundleMenu::find($promoid);
    $bundleMenu->delete();
    return \Response::json(['status' => 'ok']);
    }
    catch (\PDOException $e) {
      return back()->withError("Sorry Something Went Wrong")->withInput();
  }
  }
  //delete inclusive promotion menus
  public function deletePromoMenu($bundleDetailsId)
  {
    try{
    $promodetails = BundleDetails::find($bundleDetailsId);
    $promoid = $promodetails->bundleid;
    $promodetails->delete();
    return \Response::json(['status' => 200, 'error' => ""]);
    //return redirect('/promo/edit_promo/'.$promoid);
    }
    catch (\PDOException $e) {
      return back()->withError("Sorry Something Went Wrong")->withInput();
  }
  }
  //delete all inclusive promotion menus
  public function deleteAllMenus($bundleid)
  {
    try{
    try {
      $promo = $this->customExceptions->deletePromoException($bundleid);
    } catch (\PDOException $e) {
      return \Response::json(['status' => 500, 'error' => $e->getMessage()]);
    } catch (\Exception $e) {
      return \Response::json(['status' => 500, 'error' => $e->getMessage()]);
    }
    BundleDetails::where('bundleid', $bundleid)->delete();
    return \Response::json(['status' => 200, 'error' => ""]);
  }
  catch (\PDOException $e) {
    return back()->withError("Sorry Something Went Wrong")->withInput();
}
  }
  //edit menu quantity
  public function editQuantity($bundleDetailsID)
  {
    try{
    $user = Auth::user();
    $allMenus = Menu::all();
    $userFname = $user->empfirstname;
    $userLname = $user->emplastname;
    $userImage = $user->image;
    $bundleDetails = BundleDetails::find($bundleDetailsID);
    return view('admin.promo.editquantity', compact('allMenus', 'userLname', 'userFname', 'userImage', 'bundleDetails'));
    }
    catch (\PDOException $e) {
      return back()->withError("Sorry Something Went Wrong")->withInput();
  }
  }
  //save updated quantity to database
  public function saveEditQuantity(Request $request, $bundleDetailsID)
  {
    try {
      $promo = $this->customExceptions->editPromoQuantityException($request);
    } catch (\PDOException $e) {
      return \Response::json(['status' => 500, 'error' => $e->getMessage()]);
    }
try{
    $bundleDetails = BundleDetails::find($bundleDetailsID);
    if ($request->quantity == NULL) {
      $bundleDetails->qty = $bundleDetails->quantity;
      $bundleDetails->save();
    } else {
      $bundleDetails->qty = $request->quantity;
      $bundleDetails->save();
    }
    return redirect('/promo/edit_promo/' . $bundleDetails->bundleid)->with('success', 'Promotion Menu Quantity was edited');
  }
  catch (\PDOException $e) {
    return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
}
  }
  public function editPromoStatus($bundleid){
    try{
      $user = Auth::user();
      $userFname = $user->empfirstname;
      $userLname = $user->emplastname;
      $userImage = $user->image;
      $menuID=" ";
      return view('pages.editpromostatus', compact('userFname', 'userLname', 'userImage','bundleid','menuID'));
      }
      catch (\PDOException $e) {
          return back()->withError("Sorry Something Went Wrong ")->withInput();
      }
  }
  public function getAllBundleMenus(){
    $send = [];
    $rows = [];
    
    $promotionDetails=DB::table('bundle_details')
      ->selectRaw('group_concat(menus.menuID) as menuID')
      ->selectRaw('group_concat(menus.name) as name')
      ->selectRaw('group_concat(menus.status) as menuStatus')
      ->selectRaw('group_concat(bundles.status) as bundleStatus')
      ->selectRaw('group_concat(bundle_details.bundleid) as bundleid')
      ->selectRaw('group_concat(bundles.name )as bundlename')  
      ->selectRaw('group_concat(bundles.price) as price') 
      ->selectRaw('group_concat(bundles.servingsize) as servingsize') 
      ->selectRaw('group_concat(bundles.image) as image')
      ->join('menus','menus.menuID','=','bundle_details.menuID')
      ->join('bundles','bundle_details.bundleid','=','bundles.bundleid')
      ->groupBy('bundle_details.bundleid')
      ->get();
      foreach($promotionDetails as $row){
        $row->bundleid=explode(",",$row->bundleid)[0];
        $row->bundleStatus = explode(",",$row->bundleStatus);
        $row->bundlename=explode(",",$row->bundlename)[0];
        $row->menuID = explode(",",$row->menuID);
        $row->menuStatus = explode(",",$row->menuStatus);
        $row->price=explode(",",$row->price)[0];
        $row->servingsize=explode(",",$row->servingsize)[0];
        $row->name=explode(",",$row->name);
        array_push($send,array(
          'bundleid' => $row->bundleid,
          'name' => $row->name,
          'bundlename' => $row->bundlename,
          'menuID' => $row->menuID,
          'menuStatus'=> $row->menuStatus,
          'bundleStatus'=> $row->bundleStatus,
          'price' => $row->price,
          'servingsize' => $row->servingsize
        ));
      }
       return response()->json([
          'menus'=>$send
       ]);
       
  }
  //mobile get promo by bundle id
  public function getPromoByBundleID($bundleid)
  {
    $send = [];
    $rows = [];

    $promotionDetails = DB::table('bundle_details')
      ->selectRaw('group_concat(bundle_details.menuID) as menuID')
      ->selectRaw('group_concat(bundle_details.name) as name')
      ->selectRaw('group_concat(bundle_details.bundleid) as bundleid')
      ->selectRaw('group_concat(bundles.details )as bundlename')
      ->selectRaw('group_concat(bundles.price) as price')
      ->selectRaw('group_concat(bundles.servingsize) as servingsize')
      ->join('bundles', 'bundle_details.bundleid', '=', 'bundles.bundleid')
      ->having('bundleid', $bundleid)
      ->groupBy('bundle_details.bundleid')
      ->get();
      
      foreach ($promotionDetails as $row) {
      $row->bundleid = explode(",", $row->bundleid)[0];
      $row->bundlename = explode(",", $row->bundlename)[0];
      $row->servingsize = explode(",", $row->servingsize)[0];
      $row->name = explode(",", $row->name);
      array_push($send, array(
        'bundleid' => $row->bundleid,
        'name' => 'B' . '' . $row->name,
        'bundlename' => $row->bundlename,
        'menuID' => $row->menuID,
        'price' => $row->price,
        'servingsize' => $row->servingsize
      ));
    }
    return response()->json([
          'menus' => $send
        ]);
  }

  public function getBundleStatus($bundleId){
    $status = BundleMenu::find($bundleId)->get();

    return response()->json([
      'status'=> $status[0]['status']
    ]);
  }
  
    public function getBundleDetails($bundleId){
      $data = DB::table('bundle_details')
      ->select('menus.name', 'bundle_details.qty','bundle_details.bundleid')
      ->join('bundles','bundle_details.bundleid','=','bundles.bundleid')
      ->join('menus','bundle_details.menuID','=','menus.menuID')
      ->where('bundle_details.bundleid',$bundleId)
      ->get();

      return response()->json([
        'response' => $data
      ]);
    }
}