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
    //exception area
    private $customExceptions;

    public function __construct(CustomExceptions $customExceptions)
    {
        $this->customExceptions = $customExceptions;
    }
    //mobile get Cartegory name
    public function getCategoryName()
    {
        $allCategories = Category::all();
        $allSubs = SubCategory::all();
        return response()->json([
            'allCategories' => $allCategories,
            'allSubs'   => $allSubs,
        ]);
    }
    //add a new category page
    public function newCategory()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $allCategories = Category::all();

        return view('admin.category.add_category', compact('allCategories', 'userFname', 'userLname', 'userImage'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong ")->withInput();
        }
        
    }
    //add a new subcategory
    public function newSubCategory()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $allCategories  = Category::all();
        return view('admin.category.add_subcategory', compact('userImage', 'userFname', 'userLname', 'allCategories'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong ")->withInput();
        }
        
    }
    //generates category list for web
    public function categoryList(Request $request)
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $allCategories = Category::all();
        return view('admin.category.categorylist', compact('allCategories', 'userFname', 'userLname', 'userImage'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong ")->withInput();
        }
        
    }
    //category list for mobile
    public function apiCategoryList(Request $request)
    {
        $allCategories = Category::all();
        // return view('admin.category.categorylist', compact('allCategories'));
        return response()->json([
            'allcategories' => $allCategories
        ]);
    }
    //sub category list for web
    public function subcategoryList(Request $request)
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $allSubCategories = SubCategory::all();
        $allCategories = Category::all();
        return view('admin.category.subcategorylist', compact('allSubCategories', 'allCategories', 'userFname', 'userLname', 'userImage'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong ")->withInput();
        }
        
    }
    //saves the added category
    public function addCategory(Request $request)
    {
        try {
            $category = $this->customExceptions->addCategoryException($request);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        try{
        /**if mmode = add */
        $category = new Category;
        $category->categoryname = $request->categoryname;
        $category->description = $request->description;
        $category->save();

        return redirect('/admin/view_categories')->with('success', 'Category Added Succesfully');
        /** if mode = select */
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong please check your inputs ")->withInput();
        }
        
    }
    //editting category info function
    public function editCategory(Request $request, $id = null)
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $categoryDetails = Category::where(['categoryid' => $id])->first();

        if ($request->isMethod('post')) {
            $data = $request->all();
            //exception area
            try {
                $category = $this->customExceptions->editCategoryException($request);
            } catch (\PDOException $e) {
                return back()->withError($e->getMessage())->withInput();
            }
            Category::where(['categoryid' => $id])
                ->update(['categoryname' => $data['categoryname'], 'description' => $data['description']]);

            return redirect('/admin/view_categories')->with('success', 'Category successfully edited');
        }
        return view('admin.category.edit_category')->with(compact('categoryDetails', 'userFname', 'userLname', 'userImage'));
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong ")->withInput();
    }
    
    }
    //delete a category function
    public function deleteCategory($category_id)
    {
        try{
        $category = Category::find($category_id);
        if ($category) {
            $category->delete();
        }
        return \Response::json(['status' => 200, 'error' => ""]);
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong ")->withInput();
    }
    
    }
    //saving the added subcategory
    public function addSubCategory(Request $request)
    {
        try {
            $subcategory = $this->customExceptions->addSubCategoryException($request);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $sub = new SubCategory;
        $sub->subname = $request->subname;
        $sub->categoryid = $request->categoryid;
        $sub->save();

        return redirect('/admin/view_subcategories')->with('success', 'Sub Category Successfully added');
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong Please check your inputs ")->withInput();
        }
        
    }
    //editting subcategory info
    public function editSubCategory(Request $request, $id = null)
    {
        try{
        $subcategoryDetails = SubCategory::where(['subcatid' => $id])->first();
        $currentCategory = Category::where(['categoryid' => $subcategoryDetails['categoryid']])->first();
        $allCategories  = Category::all();
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        if ($request->isMethod('post')) {
            //exception
            try {
                $subcategory = $this->customExceptions->editSubCategoryException($request);
            } catch (\PDOException $e) {
                return back()->withError($e->getMessage())->withInput();
            }
            $data = $request->all();
            SubCategory::where(['subcatid' => $id])
                ->update(['subname' => strtoupper($data['subname']), 'categoryid' => strtoupper($data['categoryid'])]);

            return redirect('/admin/view_subcategories')->with('success', 'Sub Category successfully edited');
        }
        return view('admin.category.edit_subcategory')->with(compact('currentCategory', 'allCategories', 'subcategoryDetails', 'userFname', 'userLname', 'userImage'));
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong ")->withInput();
    }
    
    }
    //deleting a subcategory
    public function deleteSubCategory($subcategoryid)
    {
        try{
        $subcategory = SubCategory::find($subcategoryid);
        if ($subcategory) {
            $subcategory->delete();
        }
        return \Response::json(['status' => 200, 'error' => ""]);
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong ")->withInput();
    }
    
}

}
