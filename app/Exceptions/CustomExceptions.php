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
class CustomExceptions{
    // public function ResetPassException($employee){
    //     if($employee->password!=$employee->confirmpass){
    //         throw new \PDOException('Password does not match');
    //     }
    //     if($employee->password==NULL){
    //         throw new \PDOException('Password is null');
    //     }
    //     if($employee->confirmpassword==NULL){
    //         throw new \PDOException('Confirm Password is null ');
    //     }
    // }
    public function registrationException($employee){
        $checkUsername=Employee::where('username','like',$employee->username)->withTrashed()->get();
        if(count($checkUsername)!=0){
            throw new \PDOException('Username Already Exists');
        }
        if($employee->empfirstname==NULL){
            throw new \PDOException('Employee First Name is null');
        }
        if($employee->emplastname==NULL){
            throw new \PDOException('Employee Last Name is null');
        }
        if($employee->position==NULL){
            throw new \PDOException('Employee Position is null');
        }
        if($employee->username==NULL){
            throw new \PDOException('Employee Username is null');
        }
        if($employee->password==NULL){
            throw new \PDOException('Employee Password is null');
        }

    }
    public function nameException($name,$empid){
        $checkUsername=Employee::where('username','like',$name->username)->where('empid','!=',$empid)->withTrashed()->get();
        if(count($checkUsername)!=0){
            throw new \PDOException('Username Already Exists');
        }
            if($name->emplastname==NULL && $name->empfirstname==NULL && $name->username==NULL){
                throw new \PDOException('It seems that everything is Empty');
            }
            if($name->emplastname==NULL && $name->empfirstname==NULL){
                throw new \PDOException('It seems that you left your Name empty');
            }
    
          if($name->empfirstname==NULL){
           throw new \PDOException('It seems that you left your first name empty');
         }
       if($name->emplastname==NULL){
        throw new \PDOException('It seems that you left your last name empty');
       }
   
    }
    public function addPromoException($promo,$allMenus,$suggestedmenus){
        if(count($suggestedmenus)!=count(array_unique($suggestedmenus))){
            throw new \PDOException('Menu Already Selected');
           }
           $bundle=BundleDetails::get();
           $bundlename=BundleMenu::where('name', 'like', $promo->promoname)->withTrashed()->get();
           foreach($bundle as $bundles){
               if($bundles->bundleid==$promo->promoid){
                throw new \PDOException('Promotion Code Already Exists');
               }
             }
               if(count($bundlename)!=0){
                throw new \PDOException('Promotion Name Already Exists');
               }    
               if($promo->price==NULL && $promo->promoname==NULL && $promo->servingsize==NULL && $promo->promoid==NULL){
                throw new \PDOException('It seems that everything is Empty');
    
            }
            if($promo->promoid==NULL){
                throw new \PDOException('Promotion Code is Empty');
            }
            if($promo->price==NULL){
                throw new \PDOException('Price is Empty');
            }
            if($promo->promoname==NULL){
                throw new \PDOException('Promotion Name is Empty');
            }
            if($promo->servingsize==NULL){
                throw new \PDOException('Serving Size is Empty');
            }
            if(!is_numeric($promo->price)){
                throw new \PDOException('Please Enter a numeric value for price');
            }
            if(!is_numeric($promo->servingsize)){
                throw new \PDOException('Please Enter a numeric value for serving size');
            }
          
     
    }
    public function editPromoQuantityException($promo){
        if($promo->quantity==NULL){
            throw new \PDOException('Quantity Empty');
        }
    }
    public function editPromoException($promo){
        if($promo->price==NULL && $promo->promoname==NULL && $promo->servingsize==NULL ){
            throw new \PDOException('It seems that everything is Empty');

        }
        if($promo->price==NULL){
            throw new \PDOException('Price is Empty');
        }
        if($promo->promoname==NULL){
            throw new \PDOException('Promotion Name is Empty');
        }
        if($promo->servingsize==NULL){
            throw new \PDOException('Serving Size is Empty');
        }
        if(!is_numeric($promo->price)){
            throw new \PDOException('Please Enter a numeric value for price');
        }
        if(!is_numeric($promo->servingsize)){
            throw new \PDOException('Please Enter a numeric value for serving size');
        }
    }
    public function addPromoMenuException($promo,$allMenus,$suggestedmenus){
//         $promo->suggestedmenus
//  $promo->squantity
//  $promo->promoid
//  $promo->additionalmenus
for($i=0;$i<count($allMenus);$i++) {
    $menuRecord = DB::table('bundle_details')->where('bundleid','=',$promo->promoid)->where('menuID','=',$allMenus[$i])->where('deleted_at','=',NULL)->withTrashed()->get();
   if(count($menuRecord)!=0){
    throw new \PDOException('Menu Already Exists');
   }
    }
    if(count($suggestedmenus)!=count(array_unique($suggestedmenus))){
        throw new \PDOException('Menu Already Selected');
       }
 if($promo->suggestedmenus==NULL && $promo->additionalmenus==NULL){
    throw new \PDOException('Promotion Menu is Empty');
 }
 if($promo->squantity==NULL && $promo->aquantity==NULL){
    throw new \PDOException('Promotion Menu Quantity is Empty');
 }



    }
    public function EditPromoMenuException($promo,$allMenus){
        for($i=0;$i<count($allMenus);$i++) {
            $menuRecord = DB::table('bundle_details')->where('menuID','=',$allMenus[$i])->where('deleted_at','=',NULL)->withTrashed()->get();
           if(count($menuRecord)!=0){
            throw new \PDOException('Menu Already Exists');
           }
           if(count($allMenus)!=count(array_unique($allMenus))){
            throw new \PDOException('Menu Already Exists');
           }
        }
           if($promo->suggestedmenus==NULL){
            throw new \PDOException('Promotion Menu is Empty');
         }
         if($promo->suggestedmenus==NULL && $promo->additionalmenus==NULL){
            throw new \PDOException('Promotion Menu is Empty');
         }
         if($promo->squantity==NULL && $promo->aquantity==NULL){
            throw new \PDOException('Promotion Menu Quantity is Empty');
         }

    
    }
    public function deletePromoException($promo){
        $check=BundleDetails::where('bundleid',$promo)->get();
        if(count($check)==0){
            throw new \PDOException('Nothing to delete');
        }

    }
    public function addMenuException($menu){
        $checkMenuName=Menu::where('name','like',$menu->name)->get();
        if(count($checkMenuName)!=0){
            throw new \PDOException('Menu Name Already exist');
        }
        if($menu->name==NULL){
            throw new \PDOException('Menu Name is empty');
        }
        if($menu->price==NULL){
            throw new \PDOException('Price is empty');
        }
        if($menu->servingsize==NULL){
            throw new \PDOException('Serving Size is empty');
        }

    }
    public function addCategoryException($category){
        $checkCategory=Category::where('categoryname','like',$category->categoryname)->withTrashed()->get();
        if(count($checkCategory)!=0){
            throw new \PDOException('Category Name already Exists');
        }
        if($category->description==NULL){
            throw new \PDOException('Category Description is null');
        }
        if($category->categoryname==NULL){
            throw new \PDOException('Category Name is null');
        }
    }
    public function editCategoryException($category){
        $checkCategory=Category::where('categoryname','like',$category->categoryname)->withTrashed()->get();
        if(count($checkCategory)!=0){
            throw new \PDOException('Category Name already Exists');
        }
        if($category->description==NULL){
            throw new \PDOException('Category Description is null');
        }
        if($category->categoryname==NULL){
            throw new \PDOException('Category Name is null');
        }
}
public function addSubCategoryException($subcategory){
    if($subcategory->subname==NULL){
        throw new \PDOException('SubCategory Name is null');
    }
    if($subcategory->categoryid==NULL){
        throw new \PDOException('Category is null');
    }
}
public function editSubCategoryException($subcategory){
    if($subcategory->subname==NULL){
        throw new \PDOException('SubCategory Name is null');
    }
    if($subcategory->categoryid==NULL){
        throw new \PDOException('Category is null');
    }
}
public function addEmployee($employee){
    $checkEmployee=Employee::where('username','like',$employee->username)->withTrashed()->get();
    if(count($checkEmployee)!=0){
        throw new \PDOException('Username already Exists');
    }
    if($employee->empfirstname==NULL){
        throw new \PDOException('Employee First Name is null');
    }
    if($employee->emplastname==NULL){
        throw new \PDOException('Employee Last Name is null');
    }
    if($employee->position==NULL){
        throw new \PDOException('Employee Position is null');
    }
    if($employee->username==NULL){
        throw new \PDOException('Employee Username is null');
    }
    if($employee->password==NULL){
        throw new \PDOException('Employee Password is null');
    }
}
public function editEmployee($employee,$empid){
    $checkUsername=Employee::where('username','like',$employee->username)->where('empid','!=',$empid)->withTrashed()->get();
    if(count($checkUsername)!=0){
        throw new \PDOException('Username Already Exists');
    }
    if($employee->empfirstname==NULL){
        throw new \PDOException('Employee First Name is null');
    }
    if($employee->emplastname==NULL){
        throw new \PDOException('Employee Last Name is null');
    }
    if($employee->position==NULL){
        throw new \PDOException('Employee Position is null');
    }
    if($employee->emplastname==NULL){
        throw new \PDOException('Employee Last Name is null');
    }
    
}
public function addCompany($company){
    if($company->address==NULL){
        throw new \PDOException('Company Address is null');
    }
    if($company->tin==NULL){
        throw new \PDOException('Company Tin is null');
    }
    if($company->contactNo==NULL){
        throw new \PDOException('Company Contact Number is null');
    }
    if($company->email==NULL){
        throw new \PDOException('Company Email is null');
    }
    
}
public function EditCompany($company){
    if($company->address==NULL){
        throw new \PDOException('Company Address is null');
    }
    if($company->tin==NULL){
        throw new \PDOException('Company Tin is null');
    }
    if($company->contactNo==NULL){
        throw new \PDOException('Company Contact Number is null');
    }
    if($company->email==NULL){
        throw new \PDOException('Company Email is null');
    }
    
}
public function AddTable($table){
    $checkTable=RestaurantTable::where('tableno','like',$table->tablenum)->withTrashed()->get();
    if(count($checkTable)!=0){
        throw new \PDOException('Table Number already Exists');
    }
    if($table->tablenum==NULL){
        throw new \PDOException('Table Number is null');
    }
    if($table->capacity==NULL){
        throw new \PDOException('Table Number is null');
    }
    if($table->status==NULL){
        throw new \PDOException('Table Status is null');
    }
 
    
}
public function EditTable($table){
    if($table->tablenum==NULL){
        throw new \PDOException('Table Number is null');
    }
    if($table->capacity==NULL){
        throw new \PDOException('Table Number is null');
    }
    if($table->status==NULL){
        throw new \PDOException('Table Status is null');
    }
 
    
}
public function AprioriException($apriori){
    if($apriori->support<50){
        throw new \PDOException('Support Must be greater than or equal to 50');
    }
    if($apriori->confidence<50){
        throw new \PDOException('Confidence Must be greater than or equal to 50');
    }
    if($apriori->support==NULL){
        throw new \PDOException('Support is empty');
    }
    if($apriori->confidence<50){
        throw new \PDOException('Confidence is empty');
    }
}
    public function QRException($employee){
        $checkEmployee=Employee::where('empfirstname','=',$employee->firstname)->where('emplastname','=',$employee->lastname)->get();
        if(count($checkEmployee)==0){
            throw new \PDOException('Cannot Find Employee');
        }

    }
    public function DuplicateTimeInException($user_id){
        $record=EmployeeTime::whereDate('timein', '=', Carbon::today('Asia/Singapore')->toDateString())->where('user_id',$user_id)->get();
        if(count($record)!=0){
            throw new \PDOException('You have already timed in');
        }

    }
    public function NoTimeinRecordException($user_id){
        $record=EmployeeTime::whereDate('timein', '=', Carbon::today('Asia/Singapore')->toDateString())->where('user_id',$user_id)->get();
        $timeout=EmployeeTime::whereDate('timeout', '=', Carbon::today('Asia/Singapore')->toDateString())->where('user_id',$user_id)->get();
        if(count($record)==0){
            throw new \PDOException('It Seems that you did not time in for the day');
        }
        if(count($timeout)!=0){
            throw new \PDOException('You have already timed out');
        }
        

    }
   




}