<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\DB;
use Validator;
use App\AprioriSettings;
use App\Employee;
use App\Menu;
use App\Order;
use App\Apriori;
use App\BundleMenu;
use App\BundleDetails;
use App\Category;
use App\SubCategory;
use App\RestaurantTable;
use App\EmployeeTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomExceptions
{
    //Exception for registration used in Registration Controller (store function)
    public function registrationException($employee)
    {
        $checkUsername = Employee::where('username', 'like', $employee->username)->orWhere('username','like','%'.str_replace(' ','',$employee->username).'%')->withTrashed()->get();
        //for username that already existed
        if (count($checkUsername) != 0) {
            throw new \PDOException('Username Already Exists');
        }
        //for empty Employee First Name
        if ($employee->empfirstname == NULL) {
            throw new \PDOException('Employee First Name is empty');
        }
        //for empty Employee Last Name
        if ($employee->emplastname == NULL) {
            throw new \PDOException('Employee Last Name is empty');
        }
        //for empty Employee Position
        if ($employee->position == NULL) {
            throw new \PDOException('Employee Position is empty');
        }
        //for empty username
        if ($employee->username == NULL) {
            throw new \PDOException('Employee Username is empty');
        }
        //for empty password
        if ($employee->password == NULL) {
            throw new \PDOException('Employee Password is empty');
        }
    }
    //Exception for name update in profile used in Admin COntroller (saveUpdate Profile Function)
    public function nameException($name, $empid)
    {
        $checkUsername = Employee::where('username', 'like', $name->username)->orWhere('username','like','%'.str_replace(' ','',$name->username).'%')->where('empid', '!=', $empid)->withTrashed()->get();
        //for username that existed
        if (count($checkUsername) != 0) {
            throw new \PDOException('Username Already Exists');
        }
        //if submitted then everything is empty
        if ($name->emplastname == NULL && $name->empfirstname == NULL && $name->username == NULL) {
            throw new \PDOException('It seems that everything is Empty');
        }
        //if name is empty
        if ($name->emplastname == NULL && $name->empfirstname == NULL) {
            throw new \PDOException('It seems that you left your Name empty');
        }
        //if first name is empty
        if ($name->empfirstname == NULL) {
            throw new \PDOException('It seems that you left your first name empty');
        }
        //if last name is empty
        if ($name->emplastname == NULL) {
            throw new \PDOException('It seems that you left your last name empty');
        }
    }
    //for adding promotions exception used in Promotion Controller (savePromo function)
    public function addPromoException($promo, $allMenus, $suggestedmenus)
    {
        //if the menu already existed in the promotion
        if (count($suggestedmenus) != count(array_unique($suggestedmenus))) {
            throw new \PDOException('Menu Already Selected');
        }
        $bundle = BundleDetails::get();
        $bundlename = BundleMenu::where('name', 'like', $promo->promoname)->orWhere('name','like','%'.str_replace(' ','',$promo->promoname).'%')->withTrashed()->get();
        foreach ($bundle as $bundles) {
            //if Promo Code already existed (avoid duplicates)
            if ($bundles->bundleid == $promo->promoid) {
                throw new \PDOException('Promotion Code Already Exists');
            }
        }
        //if promo name already existed
        if (count($bundlename) != 0) {
            throw new \PDOException('Promotion Name Already Exists');
        }
        //if all the fileds are empty
        if ($promo->price == NULL && $promo->promoname == NULL && $promo->servingsize == NULL && $promo->promoid == NULL) {
            throw new \PDOException('It seems that everything is Empty');
        }
        //if promo code is empty
        if ($promo->promoid == NULL) {
            throw new \PDOException('Promotion Code is Empty');
        }
        //if the price is empty
        if ($promo->price == NULL) {
            throw new \PDOException('Price is Empty');
        }
        //if promotion name is empty
        if ($promo->promoname == NULL) {
            throw new \PDOException('Promotion Name is Empty');
        }
        //if serving size is empty
        if ($promo->servingsize == NULL) {
            throw new \PDOException('Serving Size is Empty');
        }
        //if the price is not numeric value
        if (!is_numeric($promo->price)) {
            throw new \PDOException('Please Enter a numeric value for price');
        }
        //if serving size is not numeric value
        if (!is_numeric($promo->servingsize)) {
            throw new \PDOException('Please Enter a numeric value for serving size');
        }
        if (count($allMenus) != count(array_unique($allMenus))) {
            throw new \PDOException('Menu Already Selected');
        }
    }
    //for editing promotion inclusive menus quantity used in Promotion Controller (editQuantity function)
    public function editPromoQuantityException($promo)
    {
        if ($promo->quantity == NULL) {
            //if the quantity is emtpty
            throw new \PDOException('Quantity Empty');
        }
    }
    //for editting promotion used in Promotion Controller(saveEditPromo function)
    public function editPromoException($promo,$bundleid)
    {
     //   $bundlename = BundleMenu::where('name', 'like', $promo->promoname)->orWhere('name','like','%'.str_replace(' ','',$promo->promoname).'%')->where('bundleid', '!=' , $bundleid)->withTrashed()->get();
          $bundlename = BundleMenu::where('name', 'LIKE', '%'.str_replace(' ','',$promo->promoname).'%')->where('bundleid','!=',$bundleid)->withTrashed()->get();
           //if promo name already existed
           if (count($bundlename) != 0) {
            throw new \PDOException('Promotion Name Already Exists');
        }
  //if all the input fields are empty
        if ($promo->price == NULL && $promo->promoname == NULL && $promo->servingsize == NULL) {
            throw new \PDOException('It seems that everything is Empty');
        }
        //if the price field is empty
        if ($promo->price == NULL) {
            throw new \PDOException('Price is Empty');
        }
        //if the promotion name is empty
        if ($promo->promoname == NULL) {
            throw new \PDOException('Promotion Name is Empty');
        }
        //if the serving size is empty
        if ($promo->servingsize == NULL) {
            throw new \PDOException('Serving Size is Empty');
        }
        //if the price isn't a numeric value
        if (!is_numeric($promo->price)) {
            throw new \PDOException('Please Enter a numeric value for price');
        }
        //if the serving size isn't a numeric value
        if (!is_numeric($promo->servingsize)) {
            throw new \PDOException('Please Enter a numeric value for serving size');
        }
    }
    //for adding promo inclusive menu exception used in Promotion Controller (saveAddPromoDetail function)
    public function addPromoMenuException($promo, $allMenus, $suggestedmenus, $additionalmenus)
    {
        //if menu already existed in the promotion
        for ($i = 0; $i < count($allMenus); $i++) {
            $menuRecord = DB::table('bundle_details')->where('bundleid', '=', $promo->promoid)->where('menuID', '=', $allMenus[$i])->where('deleted_at', '=', NULL)->get();
            if (count($menuRecord) != 0) {
                throw new \PDOException('Menu Already Exists');
            }
        }
        //if the menu is already selected 
        if (count($suggestedmenus) != count(array_unique($suggestedmenus))) {
            throw new \PDOException('Menu Already Selected');
        }
        //if promotion menu is empty
        if ($promo->suggestedmenus == NULL && $promo->additionalmenus == NULL) {
            throw new \PDOException('Promotion Menu is Empty');
        }
        //if promotion quantity is empty
        if ($promo->squantity == NULL && $promo->aquantity == NULL) {
            throw new \PDOException('Promotion Menu Quantity is Empty');
        }
    }
    //for editting promotion menu exception used in Promotion Controller ( saveEditPromoDetails function)
    public function EditPromoMenuException($promo, $allMenus)
    {
        for ($i = 0; $i < count($allMenus); $i++) {
            $menuRecord = DB::table('bundle_details')->where('menuID', '=', $allMenus[$i])->where('deleted_at', '=', NULL)->get();
            if (count($allMenus) != count(array_unique($allMenus))) {
                //if menu already existed
                throw new \PDOException('Menu Already Exists');
            }
        }
        //if promotion menu is empty
        if ($promo->suggestedmenus == NULL) {
            throw new \PDOException('Promotion Menu is Empty');
        }
        //if both bundled and addtional menus is empty
        if ($promo->suggestedmenus == NULL && $promo->additionalmenus == NULL) {
            throw new \PDOException('Promotion Menu is Empty');
        }
        //if quantity is empty
        if ($promo->squantity == NULL && $promo->aquantity == NULL) {
            throw new \PDOException('Promotion Menu Quantity is Empty');
        }
    }
    //for deleting promotion and promotion menus exception used in Promotion Controller (deleteAllMenus function)
    public function deletePromoException($promo)
    {
        $check = BundleDetails::where('bundleid', $promo)->get();
        if (count($check) == 0) {
            throw new \PDOException('Nothing to delete');
        }
    }
    //for addding menu exception used in Menu Controller (saveNewMenu function)
    public function addMenuException($menu)
    {
        //if the menu name exist
        $checkMenuName = Menu::where('name', 'LIKE', '%'. str_replace(' ','',$menu->name) .'%')->orWhere('name','like','%'.$menu->name.'%')->withTrashed()->get();
      //  $checkMenuName = Menu::WhereRaw('REPLACE ("name"," ","") LIKE "%'.str_replace(' ','%',$menu->name).'%"')->get();
        if (count($checkMenuName) != 0) {
            throw new \PDOException('Menu Name Already exist');
        }
        //if menu name is empty
        if ($menu->name == NULL) {
            throw new \PDOException('Menu Name is empty');
        }
        //if price is empty
        if ($menu->price == NULL) {
            throw new \PDOException('Price is empty');
        }
        //if serving sixze is empty
        if ($menu->servingsize == NULL) {
            throw new \PDOException('Serving Size is empty');
        }
    }
    //for addding menu exception used in Menu Controller (saveMenuUpdate function)
    public function editMenuException($menu,$menuID)
    {
        //if the menu name exist
        $checkMenuName = Menu::where('name', 'LIKE', '%'. str_replace(' ','',$menu->name) .'%')->where('menuID','!=',$menuID)->withTrashed()->get();
        if (count($checkMenuName)!=0) {
            throw new \PDOException('Menu Name Already exist');
        }
        //if menu name is empty
        if ($menu->name == NULL) {
            throw new \PDOException('Menu Name is empty');
        }
        //if price is empty
        if ($menu->price == NULL) {
            throw new \PDOException('Price is empty');
        }
        //if serving sixze is empty
        if ($menu->servingsize == NULL) {
            throw new \PDOException('Serving Size is empty');
        }
    }
    //for adding a category exception used in Category Controller (addCategory function)
    public function addCategoryException($category)
    {
        //if category name already existed (avoid duplicate name)
        $checkCategory = Category::where('categoryname', 'LIKE', '%'.str_replace(' ','',$category->categoryname).'%')->orWhere('categoryname', 'LIKE', '%'.$category->categoryname.'%')->withTrashed()->get();
        if (count($checkCategory) != 0) {
            throw new \PDOException('Category Name already Exists');
        }
        //if description is empty
        if ($category->description == NULL) {
            throw new \PDOException('Category Description is empty');
        }
        //if name is empty
        if ($category->categoryname == NULL) {
            throw new \PDOException('Category Name is empty');
        }
    }
    //for editting category exception used in Category Controller (editCategory function)
    public function editCategoryException($category)
    {
        $checkCategory = Category::where('categoryname', 'LIKE', '%'.str_replace(' ','',$category->categoryname).'%')->where('categoryid','!=',$category->categoryid)->withTrashed()->get();
        if (count($checkCategory) != 0) {
            throw new \PDOException('Category Name already Exists');
        }
        //if description is empty
        if ($category->description == NULL) {

            throw new \PDOException('Category Description is empty');
        }
        //if name is empty
        if ($category->categoryname == NULL) {
            throw new \PDOException('Category Name is empty');
        }
    }
    //for adding a subcategory exception used in category controller (addSubCategory function)
    public function addSubCategoryException($subcategory)
    {
        //if name is empty
        if ($subcategory->subname == NULL) {
            throw new \PDOException('SubCategory Name is empty');
        }
        //if category is empty
        if ($subcategory->categoryid == NULL) {
            throw new \PDOException('Category is empty');
        }
    }
    //for editing a subcategory used in Category Controller (editSubCategory function)
    public function editSubCategoryException($subcategory)
    {
        //if name is empty
        if ($subcategory->subname == NULL) {
            throw new \PDOException('SubCategory Name is empty');
        }
        //if category is empty
        if ($subcategory->categoryid == NULL) {
            throw new \PDOException('Category is empty');
        }
    }
    //for adding new employeee exception used in Employee Controller (saveNewEmployee function)
    public function addEmployee($employee)
    {
        $checkEmployee = Employee::where('username', 'like', $employee->username)->orWhere('username', 'LIKE', '%'.str_replace(' ','',$employee->username).'%')->withTrashed()->get();
        //if username already exist (to avoid username duplicates)
        if (count($checkEmployee) != 0) {
            throw new \PDOException('Username already Exists');
        }
        //if firstname is empty
        if ($employee->empfirstname == NULL) {
            throw new \PDOException('Employee First Name is empty');
        }
        // if lastname is empty
        if ($employee->emplastname == NULL) {
            throw new \PDOException('Employee Last Name is empty');
        }
        // if position is empty
        if ($employee->position == NULL) {
            throw new \PDOException('Employee Position is empty');
        }
        // if username is empty
        if ($employee->username == NULL) {
            throw new \PDOException('Employee Username is empty');
        }
        // if password is empty
        if ($employee->password == NULL) {
            throw new \PDOException('Employee Password is empty');
        }
    }
    //for editting employee information exception used in Employee Controller (veEmployeeUpdate function)
    public function editEmployee($employee, $empid)
    {
        $checkUsername = Employee::where('username', 'like', $employee->username)->where('empid', '!=', $empid)->withTrashed()->get();
        //for duplicate username 
        if (count($checkUsername) != 0) {
            throw new \PDOException('Username Already Exists');
        }
        //if first name is empty
        if ($employee->empfirstname == NULL) {
            throw new \PDOException('Employee First Name is empty');
        }
        //if last name is empty
        if ($employee->emplastname == NULL) {
            throw new \PDOException('Employee Last Name is empty');
        }
        //if position is empty
        if ($employee->position == NULL) {
            throw new \PDOException('Employee Position is empty');
        }
    }
    //company
    public function addCompany($company)
    {
        if ($company->address == NULL) {
            throw new \PDOException('Company Address is empty');
        }
        if ($company->tin == NULL) {
            throw new \PDOException('Company Tin is empty');
        }
        if ($company->contactNo == NULL) {
            throw new \PDOException('Company Contact Number is empty');
        }
        if ($company->email == NULL) {
            throw new \PDOException('Company Email is empty');
        }
    }
    //company
    public function EditCompany($company)
    {
        if ($company->address == NULL) {
            throw new \PDOException('Company Address is empty');
        }
        if ($company->tin == NULL) {
            throw new \PDOException('Company Tin is empty');
        }
        if ($company->contactNo == NULL) {
            throw new \PDOException('Company Contact Number is empty');
        }
        if ($company->email == NULL) {
            throw new \PDOException('Company Email is empty');
        }
    }
    //for adding new table exception used in Table Controller (addTable function)
    public function AddTable($table)
    {
        $checkTable = RestaurantTable::where('tableno', 'like', $table->tablenum)->withTrashed()->get();
        if (count($checkTable) != 0) {
            //for duplicate table no.
            throw new \PDOException('Table Number already Exists');
        }
        //if table no. is empty
        if ($table->tablenum == NULL) {
            throw new \PDOException('Table Number is empty');
        }
        //if capacity is empty
        if ($table->capacity == NULL) {
            throw new \PDOException('Table Capacity is empty');
        }
        //if status is empty
        if ($table->status == NULL) {
            throw new \PDOException('Table Status is empty');
        }
    }
    //for editting table information used in table controller (editTable function)
    public function EditTable($table)
    {
        $checkTable = RestaurantTable::where('tableno', 'like', $table->tablenum)->where('tableno','!=',$table->tablenum)->withTrashed()->get();
        if (count($checkTable) != 0) {
            //for duplicate table no.
            throw new \PDOException('Table Number already Exists');
        }
        //if table no. is empty
        if ($table->tablenum == NULL) {
            throw new \PDOException('Table Number is empty');
        }
        //if capacity is empty
        if ($table->capacity == NULL) {
            throw new \PDOException('Table Capacity is empty');
        }
        //if status is empty
        if ($table->status == NULL) {
            throw new \PDOException('Table Status is empty');
        }
    }
    //for setting the support and cofidence exception used in Admin Controller (saveAprioriSettings function)
    public function AprioriException($apriori)
    {
        if ($apriori->support < 50) {
            //if the support entered is less than 50
            throw new \PDOException('Support Must be greater than or equal to 50');
        }
        if ($apriori->confidence < 50) {
            //if the confidence entered is less than 50
            throw new \PDOException('Confidence Must be greater than or equal to 50');
        }
        //if the support is empty
        if ($apriori->support == NULL) {
            throw new \PDOException('Support is empty');
        }
        //if the confidence is empty
        if ($apriori->confidence < 50) {
            throw new \PDOException('Confidence is empty');
        }
    }
    //qr (not used?)
    public function QRException($employee)
    {
        $checkEmployee = Employee::where('empfirstname', '=', $employee->firstname)->where('emplastname', '=', $employee->lastname)->get();
        if (count($checkEmployee) == 0) {
            throw new \PDOException('Cannot Find Employee');
        }
    }
    //for duplicate time in exception used in Employee Controller (timein function)
    public function DuplicateTimeInException($user_id)
    {
        $record = EmployeeTime::whereDate('timein', '=', Carbon::today('Asia/Singapore')->toDateString())->where('user_id', $user_id)->get();
        if (count($record) != 0) {
            throw new \PDOException('You have already timed in');
        }
    }
    //for timeout exceptions used in Employee Controller (timeout function)
    public function NoTimeinRecordException($user_id)
    {
        $record = EmployeeTime::whereDate('timein', '=', Carbon::today('Asia/Singapore')->toDateString())->where('user_id', $user_id)->get();
        $timeout = EmployeeTime::whereDate('timeout', '=', Carbon::today('Asia/Singapore')->toDateString())->where('user_id', $user_id)->get();
        if (count($record) == 0) {
            throw new \PDOException('It Seems that you did not time in for the day');
        }
        if (count($timeout) != 0) {
            throw new \PDOException('You have already timed out');
        }
    }
}
