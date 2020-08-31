<?php

namespace App\Http\Controllers;
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
  private $customExceptions;

  public function __construct(CustomExceptions $customExceptions)
  {
      $this->customExceptions = $customExceptions;
  }
    public function createPromo(Request $request){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $ItemSets=DB::table('apriori')
        ->selectRaw('COUNT(menuID) as count')
        ->groupBy('groupNumber')
        ->distinct()
        ->get();
      //  $apriori=Apriori::get();
            $allMenus = Menu::all();
            $suggestedMenus = DB::table('apriori')
            ->join('menus','apriori.menuID','=','menus.menuID')
           ->selectRaw('group_concat(menus.menuID) as menuID')
           //->select('group_concat(bundle_menus.menuID)','menus.name')
         //   ->select('bundle_menus.bundleGroup','menus.name','bundle_menus.bundleGroup')
            ->groupBy('apriori.groupNumber')
            ->get();
            $result = [];
            foreach($suggestedMenus as $row) {
                $result[] = explode(',',$row->menuID);
            }
              $sMenus=array_values($result);
              $additionalMenus = DB::table('menus')
              ->whereNotIn('menuID',$sMenus)
              ->get();
  
    return view('admin.promo.addnewpromo',compact('userFname','userLname','sMenus','allMenus','additionalMenus','ItemSets','userImage'));
    }
    
    public function savePromo(Request $request){
      $bundledmenu=new BundleMenu();
      $allMenus=[];
      $allQuantity=[];
      $suggestedMenus=array_values(explode(',',$request->suggestedmenus));
      $additionalMenus=array_values(explode(',',$request->additionalmenus));
      $bundleQuantity=array_values(explode(',',$request->squantity));
      $additionalQuantity=array_values(explode(',',$request->aquantity));
      if($request->squantity!=NULL){
        for($j=0;$j<count($bundleQuantity);$j++){
          $allQuantity[]=$bundleQuantity[$j];
          }
        }
        if($request->aquantity!=NULL){
          for($j=0;$j<count($additionalQuantity);$j++){
            $allQuantity[]=$additionalQuantity[$j];
            }
          }
          if($request->suggestedmenus!=NULL){
            for($i=0;$i<count($suggestedMenus);$i++){
           $apriori=DB::table('apriori')->where('groupNumber',$suggestedMenus[$i])->get();
           foreach($apriori as $menus){
           $allMenus[]=$menus->menuID;
           }
        }
      
      }
        if($request->additionalmenus!=NULL){
          for($i=0;$i<count($additionalMenus);$i++){
            $additional=Menu::find($additionalMenus[$i]);
            $allMenus[]=$additional->menuID;
          }
      
        }
        try{
          $promo=$this->customExceptions->addPromoException($request,$allMenus,$suggestedMenus);
        }
        catch(\PDOException $e){
          return \Response::json(['status' =>500,'error'=>$e->getMessage()]);
        }
      $filename='CaterU.png';
              if($request->file('image')==NULL){
                  $bundledmenu->bundleid=$request->promoid;
                  $bundledmenu->name=$request->promoname;
                  $bundledmenu->price=$request->price;
                  $bundledmenu->servingsize=$request->servingsize;
                  $bundledmenu->details=$request->details;
                  $bundledmenu->image=$filename;
                 $bundledmenu->save();
  
    for($i=0;$i<count($allMenus);$i++) {
 $menuRecord = Menu::find($allMenus[$i]);
 $quantity=$allQuantity[$i];
 $row = array('menuID'=>$menuRecord->menuID,'qty'=>$quantity,'bundleid'=>$request->promoid);
 $this->addPromotionsRow($row);
 }

}
else{
      $filename = $request->file('image')->getClientOriginalName();
      $path = public_path().'/promotions/promotions_images';
      $request->file('image')->move($path, $filename);
      $bundledmenu->bundleid=$request->promoid;
       $bundledmenu->name=$request->promoname;
      $bundledmenu->price=$request->price;
      $bundledmenu->servingsize=$request->servingsize;
      $bundledmenu->details=$request->details;
        $bundledmenu->image=$filename;
      $bundledmenu->save();
  
    for($i=0;$i<count($allMenus);$i++) {
 $menuRecord = Menu::find($allMenus[$i]);
 $quantity=$allQuantity[$i];
 $row = array('menuID'=>$menuRecord->menuID,'qty'=>$quantity,'bundleid'=>$request->promoid);
 $this->addPromotionsRow($row);
 }

}
 return \Response::json(['status' =>200,'error'=>" "]);
       
    }
    private function addPromotionsRow($row) {
        DB::table('bundle_details')->insert($row);
    }
    private function EditPromotionsRow($row,$id) {
      DB::table('bundle_details')->where('bundleid',$id)->update($row);
  }
    public function promotionsList(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $promotion=BundleMenu::all();
    //     $promotionDetails=DB::table('bundle_details')
    //     ->join('bundle_menus','bundle_details.bundleid','=','bundle_menus.bundleid')
    //    ->selectRaw('group_concat(bundle_details.menuID) as menuID')
    //     ->groupBy('bundle_details.bundleid')
    //     ->get();
    //     $result = [];
    //     foreach($promotionDetails as $row) {
    //         $result[] = explode(',',$row->menuID);
    //     }
    //       $promo=array_values($result);
    $promotionDetails=BundleDetails::all();
          $allMenus = Menu::all();
        //  dd($promo);
      return view('admin.promo.promotionslist',compact('userImage','userFname','userLname','promotion','allMenus','promotionDetails'));

    }
    public function editPromo(Request $request,$bundleid){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $allMenus = Menu::all();
        if($request->isMethod('post')){
            // $data= $request->all();
            // RestaurantTable::where(['tableno'=>$tableno])
            //  ->update(['tableno'=>$data['tablenum'],'capacity' =>$data['capacity'],'status'=>$data['status']]);
     
            // return redirect('/table/tablelist');
        }
        $promotion = BundleMenu::where(['bundleid'=>$bundleid])->first();
        $promotionDetails=BundleDetails::where(['bundleid'=>$bundleid])->get();
       return view('admin.promo.editpromo')->with(compact('allMenus','userImage','userFname','userLname','promotion','promotionDetails'));
   //   dd($promotionDetails);
    }
    public function saveEditPromo(Request $request, $bundleid){
      try{
        $promo=$this->customExceptions->editPromoException($request);
       
            }
            catch(\PDOException $e){
                return back()->withError($e->getMessage())->withInput();
            }
            catch(\Exception $e){
              return back()->withError('Something Went Wrong')->withInput();
          }
      $bundlemenu=BundleMenu::find($bundleid);
      if($request->file('image')==NULL){
        $filename='CaterU.png';
      $bundlemenu->price=$request->price;
      $bundlemenu->name=$request->promoname;
      $bundlemenu->servingsize=$request->servingsize;
      $bundlemenu->details=$request->details;
      $bundlemenu->image=$bundlemenu->image;
      if($bundlemenu->image==NULL){
        $bundlemenu->image=$filename;
      }
      $bundlemenu->save();
    }
    else{
      $filename = $request->file('image')->getClientOriginalName();
      $path = public_path().'/promotions/promotions_images';
      $request->file('image')->move($path, $filename);
      $bundlemenu->price=$request->price;
      $bundlemenu->servingsize=$request->servingsize;
      $bundlemenu->details=$request->details;
      //previously bundle
      $bundlemenu->image=$request->image;
      $bundlemenu->save();

    }
    return redirect('/promo/promolist')->with('success','Promotion Information was edited');
  }
  public function addPromoDetails($bundleid){
    $user = Auth::user();
    $userFname=$user->empfirstname;
    $userLname=$user->emplastname;
    $userImage=$user->image;
    $ItemSets=DB::table('apriori')
    ->selectRaw('COUNT(menuID) as count')
    ->groupBy('groupNumber')
    ->distinct()
    ->get();
    $promotion = BundleMenu::where(['bundleid'=>$bundleid])->first();
    $promotionDetails=BundleDetails::where(['bundleid'=>$bundleid])->get();
    $allMenus = Menu::all();
    $suggestedMenus = DB::table('apriori')
    ->join('menus','apriori.menuID','=','menus.menuID')
   ->selectRaw('group_concat(menus.menuID) as menuID')
   //->select('group_concat(bundle_menus.menuID)','menus.name')
 //   ->select('bundle_menus.bundleGroup','menus.name','bundle_menus.bundleGroup')
    ->groupBy('apriori.groupNumber')
    ->get();
    $result = [];
    foreach($suggestedMenus as $row) {
        $result[] = explode(',',$row->menuID);
    }
      $sMenus=array_values($result);
      $additionalMenus = DB::table('menus')
      ->whereNotIn('menuID',$sMenus)
      ->get();
   return view('admin.promo.addnewpromodetails')->with(compact('userImage','userFname','userLname','promotion','promotionDetails','allMenus','sMenus','additionalMenus','ItemSets'));

  }
  public function saveAddPromoDetails(Request $request){
   
    $allMenus=[];
    $allQuantity=[];
    $suggestedMenus=array_values(explode(',',$request->suggestedmenus));
    $additionalMenus=array_values(explode(',',$request->additionalmenus));
    $bundleQuantity=array_values(explode(',',$request->squantity));
    $additionalQuantity=array_values(explode(',',$request->aquantity));
    if($request->squantity!=NULL){
      for($j=0;$j<count($bundleQuantity);$j++){
        $allQuantity[]=$bundleQuantity[$j];
        }
      }
      if($request->aquantity!=NULL){
        for($j=0;$j<count($additionalQuantity);$j++){
          $allQuantity[]=$additionalQuantity[$j];
          }
        }
    if($request->suggestedmenus!=NULL){
     for($i=0;$i<count($suggestedMenus);$i++){
    $apriori=DB::table('apriori')->where('groupNumber',$suggestedMenus[$i])->get();
    foreach($apriori as $menus){
    $allMenus[]=$menus->menuID;
    }
 }

}
 if($request->additionalmenus!=NULL){
   for($i=0;$i<count($additionalMenus);$i++){
     $additional=Menu::find($additionalMenus[$i]);
     $allMenus[]=$additional->menuID;
   }

 }
 try{
  $promo=$this->customExceptions->addPromoMenuException($request,$allMenus,$suggestedMenus,$additionalMenus);
 
      }
      catch(\PDOException $e){
        return \Response::json(['status'=>500,'error' =>$e->getMessage()]);
      }
    //   catch(\Exception $e){
    //     return back()->withError('Something Went Wrong')->withInput();
    // }
 for($i=0;$i<count($allMenus);$i++) {
  $menuRecord = Menu::find($allMenus[$i]);
  $quantity=$allQuantity[$i];
  $row = array('menuID'=>$menuRecord->menuID,'qty'=>$quantity,'bundleid'=>$request->promoid);
  $this->addPromotionsRow($row);
  }
return \Response::json(['status' =>200,'error'=>""]);
  }
  public function editPromoDetails(Request $request, $bundleid){
    $user = Auth::user();
    $userFname=$user->empfirstname;
    $userLname=$user->emplastname;
    $userImage=$user->image;
    $promotion = BundleMenu::where(['bundleid'=>$bundleid])->first();
    $promotionDetails=BundleDetails::where(['bundleid'=>$bundleid])->get();
    $allMenus = Menu::all();
    $ItemSets=DB::table('apriori')
    ->selectRaw('COUNT(menuID) as count')
    ->groupBy('groupNumber')
    ->distinct()
    ->get();
    $suggestedMenus = DB::table('apriori')
    ->join('menus','apriori.menuID','=','menus.menuID')
   ->selectRaw('group_concat(menus.menuID) as menuID')
   //->select('group_concat(bundle_menus.menuID)','menus.name')
 //   ->select('bundle_menus.bundleGroup','menus.name','bundle_menus.bundleGroup')
    ->groupBy('apriori.groupNumber')
    ->get();
    $result = [];
    foreach($suggestedMenus as $row) {
        $result[] = explode(',',$row->menuID);
    }
      $sMenus=array_values($result);
      $additionalMenus = DB::table('menus')
      ->whereNotIn('menuID',$sMenus)
      ->get();
   return view('admin.promo.editpromodetails')->with(compact('userImage','userFname','userLname','promotion','promotionDetails','allMenus','sMenus','additionalMenus','ItemSets'));
//   dd($promotionDetails);
    

  }
  public function saveEditPromoDetails(Request $request){
  $check=BundleDetails::where('bundleid',$request->bundleid)->get();
  $allMenus=[];
  $allQuantity=[];
  $suggestedMenus=array_values(explode(',',$request->suggestedmenus));
  $additionalMenus=array_values(explode(',',$request->additionalmenus));
  $bundleQuantity=array_values(explode(',',$request->squantity));
  $additionalQuantity=array_values(explode(',',$request->aquantity));
  if($request->squantity!=NULL){
    for($j=0;$j<count($bundleQuantity);$j++){
      $allQuantity[]=$bundleQuantity[$j];
      }
    }
    if($request->aquantity!=NULL){
      for($j=0;$j<count($additionalQuantity);$j++){
        $allQuantity[]=$additionalQuantity[$j];
        }
      }
  if($check!=NULL){
    if($request->suggestedmenus!=NULL){
     for($i=0;$i<count($suggestedMenus);$i++){
    $apriori=DB::table('apriori')->where('groupNumber',$suggestedMenus[$i])->get();
    foreach($apriori as $menus){
    $allMenus[]=$menus->menuID;
    }
 }

}
 if($request->additionalmenus!=NULL){
   for($i=0;$i<count($additionalMenus);$i++){
     $additional=Menu::find($additionalMenus[$i]);
     $allMenus[]=$additional->menuID;
   }

 }
 try{
  $promo=$this->customExceptions->EditPromoMenuException($request,$allMenus);
 
      }
      catch(\PDOException $e){
        return \Response::json(['status'=>500,'error' =>$e->getMessage()]);
      }
      catch(\Exception $e){
        return \Response::json(['status'=>500,'error' =>$e->getMessage()]);
    }
    BundleDetails::where('bundleid',$request->promoid)->delete();
 for($i=0;$i<count($allMenus);$i++) {
  $menuRecord = Menu::find($allMenus[$i]);
  $quantity=$allQuantity[$i];
  $row = array('menuID'=>$menuRecord->menuID,'qty'=>$quantity,'bundleid'=>$request->promoid);
  $this->addPromotionsRow($row);
  }
  }
else{
  if($request->suggestedmenus!=NULL){
   for($i=0;$i<count($suggestedMenus);$i++){
  $apriori=DB::table('apriori')->where('groupNumber',$suggestedMenus[$i])->get();
  foreach($apriori as $menus){
  $allMenus[]=$menus->menuID;
  }
}

}
if($request->additionalmenus!=NULL){
 for($i=0;$i<count($additionalMenus);$i++){
   $additional=Menu::find($additionalMenus[$i]);
   $allMenus[]=$additional->menuID;
 }

}
for($i=0;$i<count($allMenus);$i++) {
  $menuRecord = Menu::find($allMenus[$i]);
  $quantity=$allQuantity[$i];
  $row = array('menuID'=>$menuRecord->menuID,'qty'=>$quantity,'bundleid'=>$request->promoid);
  $this->addPromotionsRow($row);
  }

}

    return \Response::json(['status' =>200]);
  }
  public function deletePromo($promoid){
    $bundleMenu=BundleMenu::find($promoid);
    $bundleMenu->delete();
   // return redirect('/promo/promolist');
   return \Response::json(['status' =>'ok']);

  }
  public function deletePromoMenu($bundleDetailsId){
  $promodetails=BundleDetails::find($bundleDetailsId);
  $promoid=$promodetails->bundleid;
  $promodetails->delete();
  return \Response::json(['status' =>200,'error'=>""]);
  //return redirect('/promo/edit_promo/'.$promoid);
}
    public function deleteAllMenus($bundleid){
    try{
      $promo=$this->customExceptions->deletePromoException($bundleid);
    }
    catch(\PDOException $e){
      return \Response::json(['status'=>500,'error' =>$e->getMessage()]);
    }
    catch(\Exception $e){
      return \Response::json(['status'=>500,'error' =>$e->getMessage()]);
  }
    BundleDetails::where('bundleid',$bundleid)->delete();
    return \Response::json(['status' =>200,'error'=>""]);
    }

    public function editQuantity($bundleDetailsID){
      $user = Auth::user();
      $allMenus = Menu::all();
      $userFname=$user->empfirstname;
      $userLname=$user->emplastname;
      $userImage=$user->image;
      $bundleDetails=BundleDetails::find($bundleDetailsID);
      return view('admin.promo.editquantity',compact('allMenus','userLname','userFname','userImage','bundleDetails'));
    }
    public function saveEditQuantity(Request $request,$bundleDetailsID){
      try{
        $promo=$this->customExceptions->editPromoQuantityException($request);
      }
      catch(\PDOException $e){
        return \Response::json(['status'=>500,'error' =>$e->getMessage()]);
      }
    
      $bundleDetails=BundleDetails::find($bundleDetailsID);
      if($request->quantity==NULL){
        $bundleDetails->qty=$bundleDetails->quantity;
        $bundleDetails->save();
      }
      else{
        $bundleDetails->qty=$request->quantity;
        $bundleDetails->save();
      }
      return redirect('/promo/edit_promo/'.$bundleDetails->bundleid)->with('success','Promotion Menu Quantity was edited');  
    }
    public function getPromo(){
      $promotionDetails=DB::table('bundle_details')
         ->selectRaw('group_concat(bundle_details.menuID) as menuID')
         ->selectRaw('group_concat(bundle_details.name) as name')
         ->selectRaw('group_concat(bundle_details.bundleid) as bundleid')
          ->groupBy('bundle_details.bundleid')
          ->get();
          foreach($promotionDetails as $row){
            $menu[]=explode(",",$row->menuID);
            $name[]=explode(",",$row->name);
            $bundleid[]=explode(",",$row->bundleid);
           }
         return response()->json([
        'menu'=>$menu,
        'name'=>$name,
        'bundleid'=>$bundleid

         ]);




    }
    public function getFilter(){
  //     $suggestedMenus = DB::table('apriori')
  //     ->join('menus','apriori.menuID','=','menus.menuID')
  //    ->selectRaw('group_concat(count(menus.menuID)) as menuID')
  //    //->select('group_concat(bundle_menus.menuID)','menus.name')
  //  //   ->select('bundle_menus.bundleGroup','menus.name','bundle_menus.bundleGroup')
  //     ->groupBy('apriori.groupNumber')
  //     ->get();
  $ItemSets=DB::table('apriori')
  ->selectRaw('COUNT(menuID) as count')
  ->groupBy('groupNumber')
  ->distinct()
  ->get();
  //dd($suggestedMenus);
    }
}
