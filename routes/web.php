<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;
//landingpage
Route::get('analyze','AprioriC2COntroller@analyzation');
Route::get('','LoginController@landingpage');
Auth::routes(['register'=> false]);
Auth::routes(['login'=>false]);
// Route::post('/trial','AdminController@ui');
 Route::get('/trial','TemporaryTableController@getAllCompleteDrinks');
// Route::get('/trial2','PromotionController@getFilter');
Route::get('/login',function(){
    return view('create');
});
Route::post('/login',[ 'as' => 'login', 'uses' => 'LoginController@login']);
Route::post('/login',[ 'as' => 'login', 'uses' => 'LoginController@loginWeb']);
Route::post('/login/authenticate','LoginController@authenticate');
Route::get('/logout','LoginController@logout');
Route::middleware(['auth'])->group( function (){
    Route::get('/dashboard','AdminController@dashboard');
    Route::post('/orderList','AdminController@OrderListByDate');
    Route::get('/menu/list', 'MenuController@listMenus');
    Route::get('/menu/addmenu','MenuController@newMenu');
    Route::get('/menu/category','MenuController@fetch');
    Route::post('/menu/addmenu', 'MenuController@saveNewMenu');
    Route::get('/menu/{menuID}/edit','MenuController@updateMenu');
    Route::post('/menu/{menuID}/edit','MenuController@saveMenuUpdate');

    Route::get('/menu/{menuID}/mark', 'MenuController@markMenu');
    Route::get('/menu/{menuID}/delete', 'MenuController@removeMenu');
    Route::get('/menu/{menuID}/editMenuStatus','MenuController@editStatus');
    Route::post('/menu/{menuID}/{bundleid}/editStatus','MenuController@changeMenuStatus');

    Route::get('/employee/list','EmployeeController@employeeList');

    Route::get('/admin/view_categories', 'CategoryController@categoryList');
    Route::get('/admin/add_category','CategoryController@newCategory');
    Route::post('/admin/add_category','CategoryController@addCategory');
    Route::post('/admin/add_subcategory','CategoryController@addSubCategory');
    Route::get('/admin/add_subcategory','CategoryController@newSubCategory');
    Route::get('/admin/view_subcategories', 'CategoryController@subcategoryList');
    Route::get('/admin/edit_category/{categoryid}','CategoryController@editCategory');
    Route::post('/admin/edit_category/{categoryid}','CategoryController@editCategory');
    Route::get('/admin/delete_category/{categoryid}','CategoryController@deleteCategory');
    Route::get('/admin/edit_subcategory/{subcategoryid}','CategoryController@editSubCategory');
    Route::post('/admin/edit_subcategory/{subcategoryid}','CategoryController@editSubCategory');
    Route::get('/admin/delete_subcategory/{subcategoryid}','CategoryController@deleteSubCategory');
    Route::get('/apriori/apriorisettings','AdminController@setApriori');
    Route::post('/apriori/save','AdminController@saveAprioriSettings');
    Route::get('/recommendedMenus','AprioriC2Controller@showRecommendation');
    Route::get('/admin/profile','AdminController@profile');
    Route::post('/admin/profile/{employeeID}','AdminController@SaveUpdateProfile');
    //TABLE
    Route::get('/table/tablelist','TableController@webTableList');
    Route::post('/table/addtable','TableController@addTable');
    Route::get('/table/addtable','TableController@newTable');
    Route::get('/table/{tableno}/edit','TableController@editTable');
    Route::post('/table/{tableno}/edit','TableController@editTable');
    Route::get('/table/{tableno}/delete','TableController@removeTable');
    Route::get('/order/list','OrderController@allOrderList');

    //REPORTS
    Route::get('/orders/allservedmenus','OrderDetailCOntroller@getAllServedMenusWeb');
    Route::get('/orders/successfulTransaction','OrderController@successfulTransaction');
    Route::get('/generateapr','AprioriC2Controller@GenerateAprioriPage');
    Route::get('/genapr','AprioriC2Controller@addPairs');

    //EMPLOYEES
    Route::get('/employeedashboard','EmployeeController@employeeDashboard');
    Route::get('/employee/employeelist','EmployeeController@employeeList');
    Route::get('/employee/addemployee','EmployeeController@newEmployee');
    Route::post('/employee/addemployee', 'EmployeeController@saveNewEmployee');
    Route::get('/employee/edit_employee/{empid}','EmployeeController@updateEmployee');
    Route::post('/employee/edit_employee/{empid}','EmployeeController@saveEmployeeUpdate');
    Route::get('/employee/resetpass_employee/{empid}','EmployeeController@ResetEmpPass');
    Route::post('/employee/resetpass_employee/{empid}','EmployeeController@saveResetEmpPass');
    Route::get('/employee/delete_employee/{empid}','EmployeeController@removeEmployee');
    Route::get('/employee/timein','EmployeeController@timein');
    Route::get('/employee/timeout','EmployeeController@timeout');
    
    //PROMOS
    Route::get('/promo/addpromo','PromotionController@createPromo');
    Route::post('/promo/addpromo','PromotionController@savePromo');
    Route::post('/savepromo', 'PromotionController@savePromo');
    Route::get('/promo/promolist','PromotionController@promotionsList');
    Route::get('/promo/{id}/edit_promo','PromotionController@editPromo');
    Route::post('/promo/{id}/edit_promo','PromotionController@saveEditPromo');
    Route::get('/promo/delete_promo/{bundleid}','PromotionController@deletePromo');
    Route::get('/promo/add_promodetails/{bundleid}','PromotionController@addPromoDetails');
    Route::post('/promo/add_promodetails/{bundleid}','PromotionController@addPromoDetails');
    Route::get('/newpromodetails','PromotionController@saveAddPromoDetails');
    Route::post('/newpromodetails','PromotionController@saveAddPromoDetails');
    Route::get('/promo/edit_promodetails/{bundleid}','PromotionController@editPromoDetails');
    Route::post('/savepromodetails','PromotionController@saveEditPromoDetails');
    Route::get('/promo/delete_promodetails/{bundleid}','PromotionController@deleteAllMenus');
    Route::get('/promo/delete_menu_promodetails/{bundle_details_id}','PromotionController@deletePromoMenu');
    Route::get('/promo/edit_quantity/{bundledetailsid}','PromotionController@editQuantity');
    Route::post('/promo/edit_quantity/{bundledetailsid}','PromotionController@saveEditQuantity');
    Route::get('/promo/{bundleid}/editPromoStatus','PromotionController@editPromoStatus');

    ///SALES
    Route::get('/sales','ChartController@salesChart');
    Route::post('/sales','ChartController@salesChart');
    Route::post('/salesUserDefined','ChartController@getSalesUserDefined');
    Route::get('/salespermenu','ChartController@getSalesPerMenu');
    Route::get('/salesperbundle','ChartController@getSalesPerBundle');
    Route::post('/salesPerMenuDate','ChartController@getSalesPerMenuUserDefined');
    Route::post('/salesPerBundleDate','ChartController@getSalesPerBundleUserDefined');
   // Route::post('/salesSort','ChartController@salesSort');
    
    //COMPANY
    Route::get('/company/addcompany','CompanyProfileController@newCompany'); 
    Route::post('/company/addcompany','CompanyProfileController@addNewCompany');
    Route::get('/company/companylist','CompanyProfileController@companyList'); 
    Route::get('/company/edit_company/{compid}','CompanyProfileController@updateCompany');
    Route::post('/company/edit_company/{compid}','CompanyProfileController@saveCompanyUpdate');
    Route::get('/company/delete_company/{compid}','CompanyProfileController@removeCompany');
    //Ratings
    Route::get('/ratings','RatingController@getStarCount');
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', 'Frontend\HomeController@index');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/


Route::get('/createaccount', 'RegistrationController@create');
Route::post('/createaccount', 'RegistrationController@store');//
Route::get('/generateQRCode/{id}','QRController@generateQR');
Route::post('/generateQRCode/{id}','QRController@generateQR');





Route::get('/order/transaction','OrderController@paidOrder');

Route::get('/transaction','MainController@getTransactionByDate');


