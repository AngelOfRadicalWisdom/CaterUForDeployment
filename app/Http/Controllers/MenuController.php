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
use App\BundleMenu;
use App\Exceptions\CustomExceptions;
use DB;

class MenuController extends BaseController
{
    private $customExceptions;
    public function __construct(CustomExceptions $customExceptions)
    {
        //exception initialization
        $this->customExceptions = $customExceptions;
    }

    //WEB ROUTES
    //adding a new menu page 
    public function newMenu()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $allMenus = Menu::all();
        $allSubCategories = SubCategory::all();
        $allCategories = Category::all();
        

        return view('pages.addmenu', compact('userFname', 'userLname', 'allMenus', 'allCategories', 'allSubCategories', 'userImage'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
        }
    }
    //mobile get subcategories
    public function fetch(Request $request)
    {
        $categoryid = Input::get('categoryid');
        $subcategories = DB::table('sub_categories')
            ->where('categoryid', $categoryid)->get();

        return response()->json(['subs' => $subcategories]);
    }
    //save the added menu to database
    public function saveNewMenu(Request $request)
    {
        try {
            $promo = $this->customExceptions->addMenuException($request);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        try{
        $newMenu = new Menu();
        $filename = 'CaterU.png';
        if ($request->file('image') == NULL) {
            $newMenu->menuID = $request->menuID;
            $newMenu->name = $request->name;
            $newMenu->details = $request->details;
            $newMenu->price = $request->price;
            $newMenu->servingsize = $request->servingsize;
            $newMenu->image = $filename;
            $newMenu->subcatid  = $request->subcategory;
            $newMenu->status  = $request->status;


            $newMenu->save();
        } else {
            
    $this->validate($request, 

        [   'image' => 'image|mimes:jpeg,png,jpg,gif,svg',],
        ['image.image'=> 'Menu Image must be an image file type']

    );
            $filename = $request->file('image')->getClientOriginalName();

            $path = public_path() . '/menu/menu_images';
            $request->file('image')->move($path, $filename);
            $newMenu->menuID = $request->menuID;
            $newMenu->name = $request->name;
            $newMenu->details = $request->details;
            $newMenu->price = $request->price;
            $newMenu->servingsize = $request->servingsize;
            $newMenu->image = $filename;
            $newMenu->subcatid  = $request->subcategory;

            $newMenu->save();
        }
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
    }
        return redirect('/menu/list?mode=list')->with('success', 'Menu Successfully Added');
    }
    //update menu details page
    public function updateMenu($menuID)
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $allMenus = Menu::all();
        $allSubCategories = SubCategory::all();
        $allCategories = Category::all();
        $menuRecord = Menu::find($menuID);
        $SubCategoryID = SubCategory::find($menuRecord->subcatid);
        $category = Category::find($SubCategoryID->categoryid);
        return view('pages.updatemenu', compact('SubCategoryID', 'userFname', 'userLname', 'menuRecord', 'allMenus', 'allSubCategories', 'allCategories', 'category', 'userImage'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong ")->withInput();
        }
        
    }
    //update menu to database
    public function saveMenuUpdate($menuID, Request $request)
    {
        try {
            $promo = $this->customExceptions->editMenuException($request,$menuID);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        try{
        $menuRecord = Menu::find($menuID);
        if ($request->file('image') == NULL) {
            $menuRecord->name = $request->name;
            $menuRecord->details = $request->details;
            $menuRecord->price = $request->price;
            $menuRecord->servingsize = $request->servingsize;
            $menuRecord->image = $menuRecord->image;
            $menuRecord->subcatid = $request->subcategory;


            $menuRecord->save();
        } else {
            $this->validate($request, 

        [   'image' => 'image|mimes:jpeg,png,jpg,gif,svg',],
        ['image.image'=> 'Menu Image must be an image file type']

    );
            $filename = $request->file('image')->getClientOriginalName();

            $path = public_path() . '/menu/menu_images';
            $request->file('image')->move($path, $filename);

            $menuRecord->name = $request->name;
            $menuRecord->details = $request->details;
            $menuRecord->price = $request->price;
            $menuRecord->servingsize = $request->servingsize;
            $menuRecord->image = $filename;
            $menuRecord->subcatid = $request->subcategory;
            $menuRecord->save();
        }
        return redirect()->to(url('/menu/list?mode=list'))->with('success', 'Menu Successfully Edited');
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
    }

    }
    // show all menu list
    public function listMenus(Request $request)
    {
        try{
        $allMenus = Menu::all();
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;

        if ($request->mode == 'list') {
            return view('pages.menulist', compact('userImage', 'userFname', 'userLname', 'allMenus'));
        } else if ($request->mode == 'remove') {
            $menuRecords = Menu::find($request->menuID);

            if ($menuRecords) {
                $menuID = $menuRecords->menuID;
                $menuName =  $menuRecords->menuName;
                $details = $menuRecords->details;
                $price = $menuRecords->price;
                $servingsize = $menuRecords->servingsize;
                $subcatid = $menuRecords->subcatid;
                $image = $menuRecords->image;
            } else {
                $menuID = null;
                $menuNname =  null;
                $details = null;
                $price = null;
                $servingsize = null;
                $subcatid =  null;
                $image = null;
            }

            return view('pages.markmenu', compact('userImage', 'userFname', 'userLname', 'menuID', 'menuName', 'details', 'price', 'servingsize', 'subcatid', 'image', 'allMenus'));
        }
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
    }
    }
    //delete menu to list page
    public function markMenu($menuID)
    {   
        try{
        return redirect()->to(url('/menu/list?mode=remove&menuID=') . $menuID);
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    }
    //remove menu from list
    public function removeMenu($menuID)
    {
        try{
        $menuRecord = Menu::find($menuID);

        if ($menuRecord) {
            $menuRecord->delete();
        }

        return \Response::json(['status' => 200, 'error' => ""]);
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
    }
    }

    //???
    public function ionNewMenu()
    {
        $allMenus = Menu::all();
        $allCategories = Category::all();
        $allSubCategories = SubCategory::all();
        return $this->sendResponse($allMenus->toArray(), 'Menu retrieved successfully.');
    }
    //???
    public function ionListMenus(Request $request)
    {
        $allMenus = Menu::all();
        $menus = array();
        $result = array();


        foreach ($allMenus as $menu) {
            array_push($result, array(
                'image' => asset('/menu/menu_images/' . $menu->image),
                'menuID'    => $menu->menuID,
                'name'  => $menu->name,
                'status'=> $menu->status,
                'details' => $menu->details,
                'servingsize' => $menu->servingsize,
                'price' => $menu->price,
                'subcatid' => $menu->subcatid,

            ));
        }
        return  response()->json([
            'result' => $result
        ]);
    }
    public function editStatus($menuID){
        try{
            $user = Auth::user();
            $userFname = $user->empfirstname;
            $userLname = $user->emplastname;
            $userImage = $user->image;
            return view('pages.editmenustatus', compact('userFname', 'userLname', 'userImage','menuID'));
            }
            catch (\PDOException $e) {
                return back()->withError("Sorry Something Went Wrong ")->withInput();
            }

    }

    public function changeMenuStatus($menuID,$bundleid,Request $request){
        $menu = Menu::find($menuID);
        $bundle = BundleMenu::find($bundleid);
        $returnRedirect = " ";

        if($menu){
            $menu->status = $request->status;
            $menu->save();

            $this.getBundle($menu->menuID,$request->status);
            $client = new \GuzzleHttp\Client();
            $body['topic'] = "changeStatus";
            $body['content']="Testing";
            $url = "https://cateruws.zenithdevgroup.me/event/send";
            $response = $client->request("POST", $url, ['form_params'=>$body]);
            $redirect = redirect()->to(url('/menu/list?mode=list'))->with('success', 'Menu Availability Successfully Edited');
           
        }else if($bundle){
            $this.setBundleStatus($bundleid);
            $client = new \GuzzleHttp\Client();
            $body['topic'] = "changeStatus";
            $body['content']="Testing";
            $url = "https://cateruws.zenithdevgroup.me/event/send";
            $response = $client->request("POST", $url, ['form_params'=>$body]);
            $redirect = redirect()->to(url('/promo/promolist'));
        }

        // return  $response->json([
        //     'message'=> 'Status updated!'
        // ]);
        // return redirect()->to(url('/menu/list?mode=list'))->with('success', 'Menu Availability Successfully Edited');

        return $redirect;
    }

    function getBundle($menuID,$status){
      DB::table('bundle')
        ->join('bundle_details','bundle_details.bundleid','=','bundle.bundleid')
        ->join('menus','menus.menuID','=','bundle_details.menuID')
        ->where('bundle_details.menuID',$menuID)
        ->update(['bundle.status'=> $status]);
    }
    function setBundleStatus($bundleid){
        $bundle = BundleMenu::find($bundleid);
        $bundle->status = 'Not Available';
        $bundle->save();
    }

    public function getMenuDetail($id)
    {
        $menus = array();
        $menuDetail = DB::table('menus')->where('menuID', $id)->get();

        if ($menuDetail != NULL) {
            foreach ($menuDetail as $m) {
                array_push($menus, array(
                    'image' => asset('/menu/menu_images/' . $m->image),
                    'menuID' => $m->menuID,
                    'name' => $m->name,
                    'detail' => $m->details,
                    'price' => $m->price,
                    'serving_size' => $m->servingsize,
                    //  'image'=> $m->images
                ));
            }
        }

        return response()->json([
            'menudetail' => $menus
        ]);
    }
    public function getMenuByCategory($categoryid)
    {
        $menus = Menu::all();
        $menuarray = array();
        $result = array();
        $categories = Category::where('categoryid', $categoryid)->first(); // categoryid

        $allsubcategories = SubCategory::where('categoryid', $categories->categoryid)->get();
        // ->pluck('subcatid');// subcategory.categoryid

        foreach ($menus as $menu) {
            foreach ($allsubcategories as $sub) {

                if ($menu->subcatid == $sub->subcatid) {
                    array_push($result, array(
                        'image' => asset('/menu/menu_images/' . $menu->image),
                        'menuID'    => $menu->menuID,
                        'name'  => $menu->name,
                        'status'=> $menu->status,
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
