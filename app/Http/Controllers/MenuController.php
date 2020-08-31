<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\BaseController as BaseController;
use App\Menu;
use Validator;
use App\Category;
use App\SubCategory;
use App\Exceptions\CustomExceptions;
use DB;
class MenuController extends BaseController
{
    private $customExceptions;
    public function __construct(CustomExceptions $customExceptions)
  {
      $this->customExceptions = $customExceptions;
  }

//WEB ROUTES
 
    public function newMenu(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $allMenus = Menu::all();
        $allSubCategories = SubCategory::all();
        $allCategories = Category::all();

        return view('pages.addmenu', compact('userFname','userLname','allMenus', 'allCategories', 'allSubCategories','userImage'));
    }

    public function fetch(Request $request){
        $categoryid = Input::get('categoryid');
        $subcategories = DB::table('sub_categories')
            ->where('categoryid',$categoryid)->get();

            return response()->json(['subs' => $subcategories]);
    }
    public function saveNewMenu(Request $request){
        try{
            $promo=$this->customExceptions->addMenuException($request);
          }
          catch(\PDOException $e){
            return back()->withError($e->getMessage())->withInput();
          }
            $newMenu = new Menu();
            $filename='CaterU.png';
          if($request->file('image')==NULL){
            $newMenu->menuID = $request->menuID;
            $newMenu->name = $request->name;
            $newMenu->details = $request->details;
            $newMenu->price = $request->price;
            $newMenu->servingsize = $request->servingsize;
            $newMenu->image = $filename;
            $newMenu->subcatid  = $request->subcategory;
    
            $newMenu->save();
          }
         else{
        $filename = $request->file('image')->getClientOriginalName();

        $path = public_path().'/menu/menu_images';
        $request->file('image')->move($path, $filename);
        $newMenu->menuID = $request->menuID;
        $newMenu->name = $request->name;
        $newMenu->details = $request->details;
        $newMenu->price = $request->price;
        $newMenu->servingsize = $request->servingsize;
        $newMenu->image = $filename;
        $newMenu->subcatid  = $request->subcategory;

        $newMenu->save();
       
        //else
        //     return redirect()->back()->withInput()->withErrors($validation);
    }
    return redirect('/menu/list?mode=list')->with('success','Menu Successfully Added');

}

    public function updateMenu($menuID){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $allMenus = Menu::all();
        $allSubCategories = SubCategory::all();
        $allCategories = Category::all();
        $menuRecord = Menu::find($menuID);
        $SubCategoryID=SubCategory::find($menuRecord->subcatid);
        $category=Category::find($SubCategoryID->categoryid);
      return view('pages.updatemenu', compact('SubCategoryID','userFname','userLname','menuRecord', 'allMenus', 'allSubCategories', 'allCategories','category','userImage'));
    }
    public function saveMenuUpdate( $menuID,Request $request)
    {
        $menuRecord = Menu::find($menuID);
        if($request->file('image')==NULL){
            $menuRecord->name = $request->name;
            $menuRecord->details=$request->details;
            $menuRecord->price = $request->price;
            $menuRecord->servingsize = $request->servingsize;
            $menuRecord->image = $menuRecord->image;
            $menuRecord->subcatid = $request->subcategory;
    
    
            $menuRecord->save();
        }
        else{
        $filename = $request->file('image')->getClientOriginalName();

        $path = public_path().'/menu/menu_images';
        $request->file('image')->move($path, $filename);

        $menuRecord->name = $request->name;
        $menuRecord->details=$request->details;
        $menuRecord->price = $request->price;
        $menuRecord->servingsize = $request->servingsize;
        $menuRecord->image = $filename;
        $menuRecord->subcatid = $request->subcategory;
        $menuRecord->save();
        }
        return redirect()->to(url('/menu/list?mode=list'));
        // }
        // else
        //     return redirect()->back()->withInput()->withErrors($validation);
    }

    public function listMenus(Request $request) // show all menu list
    {
        $allMenus = Menu::all();
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;

        if($request->mode == 'list'){
            return view('pages.menulist', compact('userImage','userFname','userLname','allMenus'));
        }
        else if ($request->mode == 'remove') {
            $menuRecords = Menu::find($request->menuID);

            if ($menuRecords) {
                $menuID = $menuRecords->menuID;
                $menuName =  $menuRecords->menuName;
                $details = $menuRecords->details;
                $price = $menuRecords->price;
                $servingsize=$menuRecords->servingsize;
                $subcatid = $menuRecords->subcatid;
                $image = $menuRecords->image;

            }
            else {
                $menuID = null;
                $menuNname =  null;
                $details =null;
                $price = null;
                $servingsize=null;
                $subcatid =  null;
                $image = null;
            }

            return view('pages.markmenu',compact('userImage','userFname','userLname','menuID','menuName','details','price','servingsize','subcatid','image','allMenus'));
        }
    }
    public function markMenu($menuID)
    {
        return redirect()->to(url('/menu/list?mode=remove&menuID=').$menuID);
    }

    public function removeMenu($menuID)
    {
        $menuRecord = Menu::find($menuID);

        if ($menuRecord) {
            $menuRecord->delete();
        }

        return \Response::json(['status' =>200,'error'=>""]);
    }


    public function ionNewMenu(){
        $allMenus = Menu::all();
        $allCategories = Category::all();
        $allSubCategories = SubCategory::all();
        return $this->sendResponse($allMenus->toArray(), 'Menu retrieved successfully.');
    }
    public function ionListMenus(Request $request)
    {
        $allMenus = Menu::all();
        $menus = array();
        $result = array();

        
        foreach($allMenus as $menu){
            array_push($result, array(
                'image' =>asset('/menu/menu_images/'.$menu->image),
                'menuID'    => $menu->menuID,
                'name'  => $menu->name,
                'details' => $menu->details,
                'servingsize' => $menu->servingsize,
                'price' => $menu->price,
                'subcatid' => $menu->subcatid,

            ));
        }
        //if($request->mode == 'list'){
           return  response()->json([
              // 'allMenus' => $allMenus,
               'result' => $result
               ]);

    }
    public function getMenuDetail($id){
        $menus = array();
        $menuDetail = DB::table('menus')->where('menuID',$id)->get();

        if($menuDetail != NULL){
            foreach($menuDetail as $m){
                array_push($menus,array(
                    'image'=> asset('/menu/menu_images/'.$m->image),
                    'menuID'=> $m->menuID,
                    'name' => $m->name,
                    'detail'=> $m->details,
                    'price'=> $m->price,
                    'serving_size'=> $m->servingsize,
                  //  'image'=> $m->images
                ));
            }
        }

        return response()->json([
            'menudetail' => $menus
        ]);
    }
    public function getMenuByCategory($categoryid){
        $menus = Menu::all();
        $menuarray = array();
        $result = array();
    $categories = Category::where('categoryid',$categoryid)->first(); // categoryid

    $allsubcategories = SubCategory::where('categoryid',$categories->categoryid)->get();
    // ->pluck('subcatid');// subcategory.categoryid

    foreach($menus as $menu){
        foreach($allsubcategories as $sub){

            if($menu->subcatid == $sub->subcatid){
            array_push($result, array(
            'image' => asset('/menu/menu_images/'.$menu->image),
            'menuID'    => $menu->menuID,
            'name'  => $menu->name,
            'details' => $menu->details,
            'servingsize' => $menu->servingsize,
            'price' => $menu->price,
            'subcatid' => $menu->subcatid,

            ));

            }
        }
    }



      return response()->json([
          'allitems' => $result,

      ]);
    }

   
}
