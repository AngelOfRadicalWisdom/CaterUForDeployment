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
//Route::middleware('cors:api')->get('/get-q-r-code',)
Route::middleware('cors:api')->post('/QRcode/savelog','QRController@saveLog');
Route::middleware('cors:api')->get('/QRcode/verify/{id}','QRController@readQR');

//TEMPORARY TABLE

Route::middleware('cors:api')->post('/addtocart','TemporaryTableController@saveCart');
Route::middleware('cors:api')->post('/removeitemsfromcart','TemporaryTableController@removeItemsbyOrderId');
Route::middleware('cors:api')->post('/removeitemfromcart/{id}','TemporaryTableController@removeItemsbyId');
Route::middleware('cors:api')->post('/updatequantity/{id}','TemporaryTableController@updateQty');
// Route::middleware('cors:api')->get('/getItems/{tableno}','TemporaryTableController@getCartItems');
Route::middleware('cors:api')->post('/settablestatus','TableController@setTableStatus');
Route::middleware('cors:api')->get('/gettablestatusnotpaid','TableController@getTableStatusNotPaid');
Route::middleware('cors:api')->post('/settableavailable/{tableno}','TableController@setTableAvailable');
Route::middleware('cors:api')->get('/servingStatusByTableNo/{tableno}','TemporaryTableController@servingStatusByTableNo');

Route::middleware('cors:api')->post('/saveToTemporaryKitchenTable','TemporaryTableController@saveToTemporaryKitchenTable'); 
Route::middleware('cors:api')->get('/getKitchenOrders','TemporaryTableController@getKitchenOrders');
Route::middleware('cors:api')->post('/prepare/{id}','TemporaryTableController@prepare');
Route::middleware('cors:api')->post('/removeFromKitchenOrders/{id}','TemporaryTableController@removeFromKitchenOrders');
Route::middleware('cors:api')->post('/finish/{id}','TemporaryTableController@finish');
Route::middleware('cors:api')->post('/served/{id}','TemporaryTableController@served');
Route::middleware('cors:api')->post('/servemenu','TemporaryTableController@changeOrderStatusToServed');

Route::middleware('cors:api')->get('/getCartItems/{order_id}','TemporaryTableController@getCartItems');
Route::middleware('cors:api')->get('/getStatusPreparing/{id}','TemporaryTableController@isPreparing');
Route::middleware('cors:api')->get('/getAllPreparedItems','TemporaryTableController@getAllPreparedItems');
Route::middleware('cors:api')->get('/getAllCompleteList','TemporaryTableController@getAllCompleteList');
Route::middleware('cors:api')->get('/orders/getPrepareDrinks','TemporaryTableController@getDrinkPrepareOrders');
Route::middleware('cors:api')->get('/orders/getAllCompleteDrinks','TemporaryTableController@getAllCompleteDrinks');

//--------RECEPTIONIST----------//
Route::middleware('cors:api')->get('/table/tablelist','TableController@tableList');
Route::middleware('cors:api')->get('/table/getAvailableTable','TableController@getAvailableTable');
Route::middleware('cors:api')->get('/table/orderspertable/{tableno}','TableController@getOrderByTableNo');

//TABLE ORDER


//--------------KITCHEN---------------//

Route::middleware('cors:api')->get('/kitchen','KitchenController@kitchenOrders');
Route::middleware('cors:api')->get('/order/readyorder','OrderDetailController@readyOrderList');
Route::middleware('cors:api')->get('/getOrderQty/{order_id}','OrderDetailController@getItemCount');

// Route::middleware('cors:api')->post('/order/prepareMenu/{id}','KitcheController@prepareMenu');
Route::middleware('cors:api')->get('/order/readymenulist','KitchenController@getMenuReadyList');
//-------------------- S T A T U S --------------------------//
Route::middleware('cors:api')->post('/order/statusready/{id}','KitchenController@changeStatusReady');

// Route::middleware('cors:api')->post('/order/statuscook/{id}','KitchenController@cookMenu');


//----------------- CUSTOMER O R D E R R O U T E S -------------------//
Route::middleware('cors:api')->get('/menu/list', 'MenuController@ionListMenus');
Route::middleware('cors:api')->get('/menu/menudetail/{id}','MenuController@getMenuDetail');
Route::middleware('cors:api')->get('/order/list/{id}','OrderController@orderList');
Route::middleware('cors:api')->post('/order/startorder','OrderController@startOrder');
// Route::middleware('cors:api')->post('/order/placeorder','OrderDetailController@placeorder');
Route::middleware('cors:api')->post('/order/placeorder','CustomerController@placeorder');
Route::middleware('cors:api')->get('/order/{order_id}/edit','OrderController@editOrder');
Route::middleware('cors:api')->post('/order/{order_id}/update','OrderController@saveOrderUpdate');
Route::middleware('cors:api')->post('/order/{id}/delete','OrderController@removeOrderItem');
Route::middleware('cors:api')->get('/order/myorders/{order_id}','OrderDetailController@waitingOrderList');//TO VIEW ORDER FOR EACH CUSTOMER
Route::middleware('cors:api')->get('/order/myorders/served/{order_id}','OrderDetailController@servedOrderList');//TO VIEW ORDER FOR EACH CUSTOMER
Route::middleware('cors:api')->get('/order/status/waiting','OrderDetailController@orderStatusWaiting');
Route::middleware('cors:api')->post('/order/changestatus','OrderDetailController@changeOrderStatus');
Route::middleware('cors:api')->post('/order/setServedQty','OrderDetailController@setServeQty');
Route::middleware('cors:api')->post('/order/checkQty/{id}','OrderDetailController@checkQty');
Route::middleware('cors:api')->get('/order/isServed/{id}','OrderDetailController@isServed');


Route::middleware('cors:api')->post('/order/preparestatus/{orderid}','OrderDetailController@changeStatusToPrepare');
Route::middleware('cors:api')->post('/order/finishstatus/{orderid}','OrderDetailController@changeStatusToFinish');
//Route::middleware('cors:api')->post('/order/changestatustoserve/{id}','OrderDetailController@changeOrderStatusToServe');
Route::middleware('cors:api')->post('/order/changestatustoserving/{id}','OrderDetailController@changeOrderStatusToServing');
Route::middleware('cors:api')->get('/order/changestatustoserved','OrderDetailController@changeOrderStatusToServed');

Route::middleware('cors:api')->get('/order/servingmenus','OrderDetailController@getAllServingMenus');
Route::middleware('cors:api')->post('/order/status/served','OrderDetailController@serveMenu');
Route::middleware('cors:api')->get('/order/servedorders','OrderDetailController@getAllServedMenus');
Route::middleware('cors:api')->get('/kitchen/completedOrders','KitchenController@readyMenu');


Route::middleware('cors:api')->get('/order/status/served','OrderDetailController@getServeMenuId');
// Route::middleware('cors:api')->post('/order/status/preparing/{id}','OrderDetailController@orderStatusPreparing');
Route::middleware('cors:api')->get('/order/allOrders','OrderDetailController@getAllOrders');
Route::middleware('cors:api')->get('/order/getorderbyid/{id}','OrderDetailController@getOrderByID');
Route::middleware('cors:api')->get('/order/getServedOrderByID/{id}','OrderDetailController@getServedOrderByID');
Route::middleware('cors:api')->post('/order/myorders/discount/{order_id}','PaymentController@discount');
Route::middleware('cors:api')->post('/order/confirmPayment','OrderController@confirmPayment');

// Route::middleware('cors:api')->post('/order/statusserve/{id}','KitchenController@serveMenu');
Route::middleware('cors:api')->get('/order/readyList','KitchenController@getMenuReadyList');
Route::middleware('cors:api')->get('/order/getlatestorderid/{tableno}', 'OrderController@getLatestOrderID');
Route::middleware('cors:api')->get('/order/getservequantity/{id}','OrderDetailController@getServeQty');
Route::middleware('cors:api')->post('/callWaiter/{tableno}','CustomerController@callWaiter');

//Route::post('/order/billout/{order_id}','CustomerController@requestBillOut');
//---------------W A I T E R------------------//
Route::middleware('cors:api')->get('/order/drinklist','TemporaryTableController@getDrinkWaitingOrders');
Route::middleware('cors:api')->get('/order/readytoserve','WaiterController@readyToServe');
Route::middleware('cors:api')->get('/table/occupied','TableController@getOccupiedTable');
Route::middleware('cors:api')->post('/table/cleartable/{tableno}','TableController@clearTable');
Route::middleware('cors:api')->post('/setdeviceid','TableController@setDeviceTable');
Route::middleware('cors:api')->get('/getdevicetableno/{deviceuid}','TableController@getDeviceTableNo');
Route::middleware('cors:api')->get('/getdeviceid','TableController@getDeviceID');
Route::middleware('cors:api')->get('/gettablestatus/{tableno}','TableController@getTableStatus');
///-------------BILL OUT --------------------//
Route::middleware('cors:api')->post('/cashier/sendbillinfo','CashierController@sendbill');

Route::middleware('cors:api')->get('/cashier/gettotal/{orderid}','CashierController@getTotal');
Route::middleware('cors:api')->get('/cashier/billOutList','CashierController@getBillOutList');// Show all billout
Route::middleware('cors:api')->get('/cashier/getbillinfo/{order_id}','CashierController@getbilldetail');//show details per table//
Route::middleware('cors:api')->get('/cashier/getreceiptdetail/{order_id}','CashierController@getreceiptdetail');
Route::middleware('cors:api')->post('/cashier/setTotal','PaymentController@setTotal');
Route::middleware('cors:api')->get('/cashier/getSubTotal/{id}','PaymentController@getSubTotal');
// Route::middleware('cors:api')->post('/cashier/sendbillinfo/{order_id}','CashierController@updateTotal');
Route::middleware('cors:api')->post('/cashier/confirmPayment/{order_id}','PaymentController@confirmPayment');
Route::middleware('cors:api')->post('/cashier/printReceipt','PaymentController@printReceipt');

// Route::get('/customer/addNCustomer','CustomerController@newCustomer');
 Route::middleware('cors:api')->post('/customer/setNewCustomer','CustomerController@addCustomer');

// Route::post('/concern/store/{tableno}','TemporaryTableController@storeConcern');

Route::middleware('cors:api')->get('/get/sum/{menuID}','OrderDetailController@sumOrderQty');

//EMPLOYEE

Route::middleware('cors:api')->get('/employee/employeename/{id}','EmployeeController@getEmpName');
Route::middleware('cors:api')->get('/employee/getposition/{username}','EmployeeController@getPosition');

//MENU
Route::middleware('cors:api')->get('/menu/categorylist','CategoryController@apiCategoryList');
Route::middleware('cors:api')->get('/menu/subcategorylist','CategoryController@apiSubCategoryList');
Route::middleware('cors:api')->get('/menu/getmenubycategory/{categoryid}','MenuController@getMenuByCategory');

//APRIORI
Route::middleware('cors:api')->get('/apriori/getpairs','AprioriC2Controller@sendApriori');

//SMS
Route::middleware('cors:api')->post('/sendSMS/{custid}','SMS@sendSMS');
Route::middleware('cors:api')->post('/addcustomer','CustomerController@addCustomer');
Route::middleware('cors:api')->get('/getreservedcustomer','CustomerController@getReservedCustomer');
Route::middleware('cors:api')->post('/status/present/{custid}','CustomerController@setStatusPresent');
Route::middleware('cors:api')->post('/status/notified/{custid}','CustomerController@setNotified');
Route::middleware('cors:api')->post('/status/cancelled/{custid}','CustomerController@setStatusCancelled');
Route::middleware('cors:api')->get('/getnotifiedcustomer','CustomerController@getNotified');

Route::middleware('cors:api')->get('/test','SMS@test');
Route::middleware('cors:api')->get('/getphonenumber/{custid}','CustomerController@getPhonenumber');
Route::middleware('cord:api')->post('/status/notified/{custid}','CustomerController@setNotified');
