<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\SubCategory;
use App\Exceptions\CustomExceptions;
use DB;
class CategoryController extends BaseController
{
    private $customExceptions;

    public function __construct(CustomExceptions $customExceptions)
    {
        $this->customExceptions = $customExceptions;
    }
    public function getCategoryName(){
        $allCategories= Category::all();
        $allSubs = SubCategory::all();
        return response()->json([
            'allCategories' => $allCategories,
            'allSubs'   => $allSubs,
        ]);
    }
    public function newCategory(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $allCategories = Category::all();

        return view('admin.category.add_category',compact('allCategories','userFname','userLname','userImage'));
    }
    public function newSubCategory(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $allCategories  = Category::all();
        return view('admin.category.add_subcategory',compact('userImage','userFname','userLname','allCategories'));
    }
    public function categoryList(Request $request){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $allCategories = Category::all();
            return view('admin.category.categorylist', compact('allCategories','userFname','userLname','userImage'));


    }
    public function apiCategoryList(Request $request){
        $allCategories = Category::all();
           // return view('admin.category.categorylist', compact('allCategories'));
        return response()->json([
            'allcategories' => $allCategories
        ]);

    }
    public function subcategoryList(Request $request){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $allSubCategories = SubCategory::all();
        $allCategories = Category::all();
            return view('admin.category.subcategorylist', compact('allSubCategories','allCategories','userFname','userLname','userImage'));


    }
    public function addCategory(Request $request){
        try{
            $category=$this->customExceptions->addCategoryException($request);
          }
          catch(\PDOException $e){
            return back()->withError($e->getMessage())->withInput();
          }
        /**if mmode = add */
            $category = new Category;
            $category->categoryname = $request->categoryname;
            $category->description = $request->description;
            $category->save();

       return redirect('/admin/view_categories')->with('success','Category Added Succesfully');
       /** if mode = select */
    }

    public function editCategory(Request $request, $id=null){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $categoryDetails = Category::where(['categoryid'=> $id])->first();

       if($request->isMethod('post')){
           $data= $request->all();
           try{
            $category=$this->customExceptions-> editCategoryException($request);
          }
          catch(\PDOException $e){
            return back()->withError($e->getMessage())->withInput();
          }
           Category::where(['categoryid'=>$id])
            ->update(['categoryname'=>$data['categoryname'],'description' => $data['description']]);

           return redirect('/admin/view_categories')->with('success','Category successfully edited');
       }
       return view('admin.category.edit_category')->with(compact('categoryDetails','userFname','userLname','userImage'));
    }
    public function deleteCategory($category_id)
    {
        $category = Category::find($category_id);
        if($category){
            $category->delete();
        }
        return \Response::json(['status' =>200,'error'=>""]);
    }

    public function addSubCategory(Request $request){
        try{
            $subcategory=$this->customExceptions-> addSubCategoryException($request);
          }
          catch(\PDOException $e){
            return back()->withError($e->getMessage())->withInput();
          }
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $sub = new SubCategory;
        $sub->subname = $request->subname;
        $sub->categoryid = $request->categoryid;
        $sub->save();

   return redirect('/admin/view_subcategories')->with('success','Sub Category Successfully added');
}
public function editSubCategory(Request $request,$id=null){
    $subcategoryDetails = SubCategory::where(['subcatid'=> $id])->first();
   $currentCategory=Category::where(['categoryid'=>$subcategoryDetails['categoryid']])->first();
   $allCategories  = Category::all();
    $user = Auth::user();
    $userFname=$user->empfirstname;
    $userLname=$user->emplastname;
    $userImage=$user->image;
   if($request->isMethod('post')){
    try{
        $subcategory=$this->customExceptions->editSubCategoryException($request);
      }
      catch(\PDOException $e){
        return back()->withError($e->getMessage())->withInput();
      }
       $data= $request->all();
       SubCategory::where(['subcatid'=>$id])
        ->update(['subname'=>strtoupper($data['subname']),'categoryid' =>strtoupper($data['categoryid'])]);

       return redirect('/admin/view_subcategories')->with('success','Sub Category successfully edited');
   }
  // dd($currentCategory->categoryid);
 return view('admin.category.edit_subcategory')->with(compact('currentCategory','allCategories','subcategoryDetails','userFname','userLname','userImage'));
}
public function deleteSubCategory($subcategoryid)
{
    $subcategory = SubCategory::find($subcategoryid);
    if($subcategory){
        $subcategory->delete();
    }
    return \Response::json(['status' =>200,'error'=>""]);
}
}
