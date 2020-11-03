<?php

use Illuminate\Http\Request;



Route::middleware('cors:api')->get('/login',function(){
    return view('create');
});
Route::middleware('cors:api')->post('/login',[ 'as' => 'login', 'uses' => 'LoginController@login']);
Route::middleware('cors:api')->post('/login/authenticate','LoginController@authenticate');
Route::middleware('cors:api')->get('/logout','LoginController@logout');

//QR

Route::group(['middleware' => ['web']], function () {
    Route::get('/getsession/{id}','SessionController@accessSessionData');
});
Route::middleware('cors:api')->post('/QRcode/savelog','QRController@saveLog');
Route::middleware('cors:api')->get('/QRcode/verify/{id}','QRController@readQR');

//TEMPORARY TABLE

Route::middleware('cors:api')->post('/addtocart','TemporaryTableController@saveCart');
Route::middleware('cors:api')->post('/removeitemfromcart/{id}','TemporaryTableController@removeItembyId');
Route::middleware('cors:api')->post('/updatequantity/{id}','TemporaryTableController@updateQty');
Route::middleware('cors:api')->get('/getItems/{orderId}','TemporaryTableController@getCartItems');
Route::middleware('cors:api')->post('/settableavailable/{tableno}','TableController@setTableAvailable');
Route::middleware('cors:api')->post('/settableoccupied/{tableno}','TableController@setTableOccupied');
Route::middleware('cors:api')->get('/servingStatusByTableNo/{tableno}','TemporaryTableController@servingStatusByTableNo');


Route::middleware('cors:api')->get('/getKitchenOrders','TemporaryTableController@getKitchenOrders');
Route::middleware('cors:api')->post('/prepare/{id}','TemporaryTableController@prepare');
Route::middleware('cors:api')->post('/status/forserving/{id}','TemporaryTableController@isForServing');
Route::middleware('cors:api')->post('/status/isReady/{id}','TemporaryTableController@isReady');
Route::middleware('cors:api')->post('/status/isServed/{id}','TemporaryTableController@isServed');
Route::middleware('cors:api')->post('/servemenu','TemporaryTableController@changeOrderStatusToServed');
Route::middleware('cors:api')->get('/checkForReadyOrders', 'TemporaryTableController@checkForReadyOrders');

Route::middleware('cors:api')->get('/getCartItems/{order_id}','TemporaryTableController@getCartItems');
Route::middleware('cors:api')->get('/getAllPreparedItems','TemporaryTableController@getAllPreparedItems');
Route::middleware('cors:api')->get('/getAllCompleteList','TemporaryTableController@getAllCompleteList');
Route::middleware('cors:api')->get('/orders/getPrepareDrinks','TemporaryTableController@getDrinkPrepareOrders');
Route::middleware('cors:api')->get('/orders/getAllCompleteDrinks','TemporaryTableController@getAllCompleteDrinks');

//--------RECEPTIONIST----------//
Route::middleware('cors:api')->get('/table/tablelist','TableController@tableList');
Route::middleware('cors:api')->get('/table/getAvailableTable','TableController@getAvailableTable');
Route::middleware('cors:api')->post('/reserveNewCustomer','CustomerController@reserveNewCustomer');
Route::middleware('cors:api')->post('/assignTable/{custid}','CustomerController@assignTable');
Route::middleware('cors:api')->post('/customer/notified/remove/{custId}', 'CustomerController@deleteNotifiedCustomer');
//----------------- CUSTOMER O R D E R R O U T E S -------------------//
Route::middleware('cors:api')->get('/menu/list', 'MenuController@ionListMenus');
Route::middleware('cors:api')->post('/order/placeorder/{order_id}','CustomerController@placeorder');
Route::middleware('cors:api')->get('/order/myorders/{order_id}','OrderDetailController@orderList');
Route::middleware('cors:api')->post('/order/setServedQty','OrderDetailController@setServeQty');
Route::middleware('cors:api')->post('/order/isServed/{id}','OrderDetailController@isServed');
Route::middleware('cors:api')->get('/getTotal/{order_id}','OrderDetailController@getTotal');

Route::middleware('cors:api')->post('/order/billout/{order_id}','CustomerController@requestBillOut');
//---------------W A I T E R------------------//
Route::middleware('cors:api')->get('/order/drinklist','TemporaryTableController@getDrinkWaitingOrders');
Route::middleware('cors:api')->get('/table/occupied','TableController@getOccupiedTable');
Route::middleware('cors:api')->post('/table/transfer/{tableno}','TableController@tableTransfer');
Route::middleware('cors:api')->get('/order/begintransaction/{tableno}','TableController@beginTransaction');
Route::middleware('cors:api')->get('/cashier/billOutList','CashierController@getBillOutList');// Show all billout
Route::middleware('cors:api')->get('/cashier/getbillinfo/{tableNo}','CashierController@getbilldetail');//show details per table//
Route::middleware('cors:api')->post('/cashier/printReceipt/{order_id}','PaymentController@printReceipt');

//MENU
Route::middleware('cors:api')->get('/menu/categorylist','CategoryController@apiCategoryList');
Route::middleware('cors:api')->get('/menu/subcategorylist','CategoryController@apiSubCategoryList');
Route::middleware('cors:api')->get('/menu/getmenubycategory/{categoryid}','MenuController@getMenuByCategory');
Route::middleware('cors:api')->get('/menu/getBundleMenus','PromotionController@getAllBundleMenus');
Route::middleware('cors:api')->get('/menu/bundle/getbundledetails/{bundleId}','PromotionController@getBundleDetails');
//APRIORI
Route::middleware('cors:api')->get('/apriori/getpairs/{menuId}','AprioriC2Controller@sendApriori');

//SMS
Route::middleware('cors:api')->post('/sendSMS/{custid}','SMS@sendSMS');
Route::middleware('cors:api')->get('/getreservedcustomer','CustomerController@getReservedCustomer');
Route::middleware('cors:api')->post('/status/present/{custid}','CustomerController@setStatusPresent');
Route::middleware('cors:api')->post('/status/notified/{custid}','CustomerController@setNotified');
Route::middleware('cors:api')->post('/status/cancelled/{custid}','CustomerController@setStatusCancelled');
Route::middleware('cors:api')->get('/getnotifiedcustomer','CustomerController@getNotified');

Route::middleware('cors:api')->get('/getphonenumber/{custid}','CustomerController@getPhonenumber');
Route::middleware('cord:api')->post('/status/notified/{custid}','CustomerController@setNotified');



//RATING

Route::middleware('cors:api')->post('/rateUs','RatingController@rate');