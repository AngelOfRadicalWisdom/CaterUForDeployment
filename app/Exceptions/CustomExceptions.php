<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\DB;
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
        $checkUsername = Employee::where('username', 'like', $employee->username)->withTrashed()->get();
        //for username that already existed
        if (count($checkUsername) != 0) {
            throw new \PDOException('Username Already Exists');
        }
        //for null Employee First Name
        if ($employee->empfirstname == NULL) {
            throw new \PDOException('Employee First Name is null');
        }
        //for null Employee Last Name
        if ($employee->emplastname == NULL) {
            throw new \PDOException('Employee Last Name is null');
        }
        //for null Employee Position
        if ($employee->position == NULL) {
            throw new \PDOException('Employee Position is null');
        }
        //for null username
        if ($employee->username == NULL) {
            throw new \PDOException('Employee Username is null');
        }
        //for null password
        if ($employee->password == NULL) {
            throw new \PDOException('Employee Password is null');
        }
    }
    //Exception for name update in profile used in Admin COntroller (saveUpdate Profile Function)
    public function nameException($name, $empid)
    {
        $checkUsername = Employee::where('username', 'like', $name->username)->where('empid', '!=', $empid)->withTrashed()->get();
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
        $bundlename = BundleMenu::where('name', 'like', $promo->promoname)->withTrashed()->get();
        foreach ($bundle as $bundles) {
            //if Promo Code already existed
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
    public function editPromoException($promo)
    {
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
    public function EditPromoMenuException($promo, $allMenus)
    {
        for ($i = 0; $i < count($allMenus); $i++) {
            $menuRecord = DB::table('bundle_details')->where('menuID', '=', $allMenus[$i])->where('deleted_at', '=', NULL)->get();
            if (count($allMenus) != count(array_unique($allMenus))) {
                throw new \PDOException('Menu Already Exists');
            }
        }
        if ($promo->suggestedmenus == NULL) {
            throw new \PDOException('Promotion Menu is Empty');
        }
        if ($promo->suggestedmenus == NULL && $promo->additionalmenus == NULL) {
            throw new \PDOException('Promotion Menu is Empty');
        }
        if ($promo->squantity == NULL && $promo->aquantity == NULL) {
            throw new \PDOException('Promotion Menu Quantity is Empty');
        }
    }
    public function deletePromoException($promo)
    {
        $check = BundleDetails::where('bundleid', $promo)->get();
        if (count($check) == 0) {
            throw new \PDOException('Nothing to delete');
        }
    }
    public function addMenuException($menu)
    {
        $checkMenuName = Menu::where('name', 'like', $menu->name)->get();
        if (count($checkMenuName) != 0) {
            throw new \PDOException('Menu Name Already exist');
        }
        if ($menu->name == NULL) {
            throw new \PDOException('Menu Name is empty');
        }
        if ($menu->price == NULL) {
            throw new \PDOException('Price is empty');
        }
        if ($menu->servingsize == NULL) {
            throw new \PDOException('Serving Size is empty');
        }
    }
    public function addCategoryException($category)
    {
        $checkCategory = Category::where('categoryname', 'like', $category->categoryname)->withTrashed()->get();
        if (count($checkCategory) != 0) {
            throw new \PDOException('Category Name already Exists');
        }
        if ($category->description == NULL) {
            throw new \PDOException('Category Description is null');
        }
        if ($category->categoryname == NULL) {
            throw new \PDOException('Category Name is null');
        }
    }
    public function editCategoryException($category)
    {
        $checkCategory = Category::where('categoryname', 'like', $category->categoryname)->withTrashed()->get();
        if (count($checkCategory) != 0) {
            throw new \PDOException('Category Name already Exists');
        }
        if ($category->description == NULL) {
            throw new \PDOException('Category Description is null');
        }
        if ($category->categoryname == NULL) {
            throw new \PDOException('Category Name is null');
        }
    }
    public function addSubCategoryException($subcategory)
    {
        if ($subcategory->subname == NULL) {
            throw new \PDOException('SubCategory Name is null');
        }
        if ($subcategory->categoryid == NULL) {
            throw new \PDOException('Category is null');
        }
    }
    public function editSubCategoryException($subcategory)
    {
        if ($subcategory->subname == NULL) {
            throw new \PDOException('SubCategory Name is null');
        }
        if ($subcategory->categoryid == NULL) {
            throw new \PDOException('Category is null');
        }
    }
    public function addEmployee($employee)
    {
        $checkEmployee = Employee::where('username', 'like', $employee->username)->withTrashed()->get();
        if (count($checkEmployee) != 0) {
            throw new \PDOException('Username already Exists');
        }
        if ($employee->empfirstname == NULL) {
            throw new \PDOException('Employee First Name is null');
        }
        if ($employee->emplastname == NULL) {
            throw new \PDOException('Employee Last Name is null');
        }
        if ($employee->position == NULL) {
            throw new \PDOException('Employee Position is null');
        }
        if ($employee->username == NULL) {
            throw new \PDOException('Employee Username is null');
        }
        if ($employee->password == NULL) {
            throw new \PDOException('Employee Password is null');
        }
    }
    public function editEmployee($employee, $empid)
    {
        $checkUsername = Employee::where('username', 'like', $employee->username)->where('empid', '!=', $empid)->withTrashed()->get();
        if (count($checkUsername) != 0) {
            throw new \PDOException('Username Already Exists');
        }
        if ($employee->empfirstname == NULL) {
            throw new \PDOException('Employee First Name is null');
        }
        if ($employee->emplastname == NULL) {
            throw new \PDOException('Employee Last Name is null');
        }
        if ($employee->position == NULL) {
            throw new \PDOException('Employee Position is null');
        }
        if ($employee->emplastname == NULL) {
            throw new \PDOException('Employee Last Name is null');
        }
    }
    public function addCompany($company)
    {
        if ($company->address == NULL) {
            throw new \PDOException('Company Address is null');
        }
        if ($company->tin == NULL) {
            throw new \PDOException('Company Tin is null');
        }
        if ($company->contactNo == NULL) {
            throw new \PDOException('Company Contact Number is null');
        }
        if ($company->email == NULL) {
            throw new \PDOException('Company Email is null');
        }
    }
    public function EditCompany($company)
    {
        if ($company->address == NULL) {
            throw new \PDOException('Company Address is null');
        }
        if ($company->tin == NULL) {
            throw new \PDOException('Company Tin is null');
        }
        if ($company->contactNo == NULL) {
            throw new \PDOException('Company Contact Number is null');
        }
        if ($company->email == NULL) {
            throw new \PDOException('Company Email is null');
        }
    }
    public function AddTable($table)
    {
        $checkTable = RestaurantTable::where('tableno', 'like', $table->tablenum)->withTrashed()->get();
        if (count($checkTable) != 0) {
            throw new \PDOException('Table Number already Exists');
        }
        if ($table->tablenum == NULL) {
            throw new \PDOException('Table Number is null');
        }
        if ($table->capacity == NULL) {
            throw new \PDOException('Table Number is null');
        }
        if ($table->status == NULL) {
            throw new \PDOException('Table Status is null');
        }
    }
    public function EditTable($table)
    {
        if ($table->tablenum == NULL) {
            throw new \PDOException('Table Number is null');
        }
        if ($table->capacity == NULL) {
            throw new \PDOException('Table Number is null');
        }
        if ($table->status == NULL) {
            throw new \PDOException('Table Status is null');
        }
    }
    public function AprioriException($apriori)
    {
        if ($apriori->support < 50) {
            throw new \PDOException('Support Must be greater than or equal to 50');
        }
        if ($apriori->confidence < 50) {
            throw new \PDOException('Confidence Must be greater than or equal to 50');
        }
        if ($apriori->support == NULL) {
            throw new \PDOException('Support is empty');
        }
        if ($apriori->confidence < 50) {
            throw new \PDOException('Confidence is empty');
        }
    }
    public function QRException($employee)
    {
        $checkEmployee = Employee::where('empfirstname', '=', $employee->firstname)->where('emplastname', '=', $employee->lastname)->get();
        if (count($checkEmployee) == 0) {
            throw new \PDOException('Cannot Find Employee');
        }
    }
    public function DuplicateTimeInException($user_id)
    {
        $record = EmployeeTime::whereDate('timein', '=', Carbon::today('Asia/Singapore')->toDateString())->where('user_id', $user_id)->get();
        if (count($record) != 0) {
            throw new \PDOException('You have already timed in');
        }
    }
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
