<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\RestaurantTable;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\Customer;
use App\Exceptions\CustomExceptions;
use DB;

class TableController extends BaseController
{
    //exception initialization
    private $customExceptions;

    public function __construct(CustomExceptions $customExceptions)
    {
        $this->customExceptions = $customExceptions;
    }
    // mobile get table list
    public function tableList()
    {
        $tables=[];
        $allTables = RestaurantTable::all();
        $orderTables = DB::table('tables')
        ->select('orders.tableno','orders.status')
        ->join('orders','orders.tableno','=','tables.tableno')
        ->where('orders.status','billout')
        ->get();

        foreach($allTables as $table){
            if(COUNT($orderTables)>0){
                   foreach($orderTables as $o){
                    if($table->tableno == $o->tableno){
                    array_push($tables, array(
                        "status"=> $o->status,
                        "tableno"=>$table->tableno,
                        "capacity"=>$table->capacity
                    ));
                }else{
                    array_push($tables, array(
                        "status"=> $table->status,
                        "tableno"=>$table->tableno,
                        "capacity"=>$table->capacity
                    ));
                }
            }
            }else{
                array_push($tables, array(
                    "status"=> $table->status,
                    "tableno"=>$table->tableno,
                    "capacity"=>$table->capacity
                ));
            }
         
        }

        return response()->json(['allTables' => $tables]);
    }
    //admin table list
    public function webTableList()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $allTables = RestaurantTable::all();
        return view('admin.tablelist', compact('userImage', 'allTables', 'userFname', 'userLname'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    }
    //mobile get available table
    public function getAvailableTable()
    {
        $availableTables = DB::table('tables')->where('status', 'Available')->get();

        return response()->json([
            'AvailableTables' => $availableTables
        ]);
    }
    //mobile get occupied table
    public function getOccupiedTable()
    {
        $occupiedTables = DB::table('tables')->where('status', 'Occupied')->get();

        return response()->json([
            'OccupiedTables' => $occupiedTables
        ]);
    }
    // create new table
    public function newTable()
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $currentTable= RestaurantTable::orderBy('tableno', 'DESC')->first();
        $ctableno=$currentTable->tableno;
        return view('addtables', compact('userImage', 'userFname', 'userLname','ctableno'));
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    }
    //save new table
    public function addTable(Request $request)
    {
        try{
        try {
            $table = $this->customExceptions->AddTable($request);
        } catch (\PDOException $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        $table = new RestaurantTable;
        $table->tableno = $request->tablenum;
        $table->capacity = $request->capacity;
        $table->status = $request->status;

        $table->save();

        return redirect('/table/tablelist')->with('success', 'Table Successfully Created')->withInput();
        }
        catch (\PDOException $e) {
            return back()->withError("Sorry Something Went Wrong")->withInput();
        }
    }
    //remove table from list

    public function removeTable($tableno)
    {
        try{
        $Table = RestaurantTable::find($tableno);

        if ($Table) {
            $Table->delete();
        }

        return \Response::json(['status' => 200, 'error' => ""]);
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong")->withInput();
    }
    }
    //edit table 
    public function editTable(Request $request, $tableno = null)
    {
        try{
        $user = Auth::user();
        $userFname = $user->empfirstname;
        $userLname = $user->emplastname;
        $userImage = $user->image;
        $tables = RestaurantTable::where(['tableno' => $tableno])->first();
        if ($request->isMethod('post')) {
            $data = $request->all();
            try {
                $table = $this->customExceptions->EditTable($request);
            } catch (\PDOException $e) {
                return back()->withError($e->getMessage())->withInput();
            }
            RestaurantTable::where(['tableno' => $tableno])
                ->update(['tableno' => $data['tablenum'], 'capacity' => $data['capacity'], 'status' => $data['status']]);

            return redirect('/table/tablelist')->with('success', 'Table Successfully Updated');
        }
        return view('edit_tables')->with(compact('userImage', 'tables', 'userFname', 'userLname'));
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please Check your inputs")->withInput();
    }
    }
    //mobile table transfer
    public function requestTableTransfer($order_id, Request $request)
    {
        $table = Table::find($request->tableno);
        if ($table->status == 'occupied') {
            return response()->json([
                'error_message' => 'The table' . $table . 'is not Avaible'
            ]);
        } else {
            $order = Order::find($order_id);
            $order->tableno = $table->tableno;
            $order->save();

            return response()->json([
                'message' => 'Table transfer is successful!'
            ]);
        }
    }

    public function setTableOccupied(Request $request){
        $table = RestaurantTable::find($request->tableno);
        if ($table->status == 'Available') {
            $table->status = 'Occupied';
        }

        $table->save();

        return response()->json([
            'message' => 'Table is set'
        ]);
    }
    //mobile set table status to available
    public function setTableAvailable($tableno,Request $request)
    {
        $table = RestaurantTable::find($tableno);
        $table->status = 'Available';
        $table->save();

        return response()->json([
            'message' => 'available'
        ]);
    }
    public function clearTable($tableno,Request $request)
    {
        $table = RestaurantTable::find($tableno);
        $table->status = 'Available';
        $table->save();

        $temp = DB::table('temporary_orders')
        ->where('order_id',$request->orderId)
        ->delete();
        
        $kitchen = DB::table('kitchenrecords')
        ->where('order_id',$request->orderId)
        ->delete();

        return response()->json([
            'message' => 'available'
        ]);
    }

    public function tableTransfer($tableno,Request $request){
        $table=RestaurantTable::find($request->tableno);
       
        DB::table('orders')
        ->where('tableno',$tableno)
        ->where('status','ordering')
        ->update(['tableno' => $request->tableno]);
        $table->status = 'Occupied';
        $table->save();


        $transferTo=RestaurantTable::find($tableno);
        $transferTo->status = "Available";
        $transferTo->save();
       
        return response()->json([
            'message' => 'updated'
        ]);
    }

    //mobile set device table
    public function setDeviceTable(Request $request)
    {
        $message = '';

        $table = RestaurantTable::find($request->tableno);
        if ($table->status != 'Occupied') {
            $table->deviceuid = $request->deviceuid;
            $table->save();

            $message = "Table is set";
        } else {
            $message = "Table is occupied";
        }




            return response()->json([
                'message' => $message
            ]);
        }

    
    public function getTableStatus($tableno){
        $status ='';
        $table = RestaurantTable::find($tableno);
        if ($table->status == 'Available') {
            $status = 'Available';
        } else {
            $status = 'Occupied';
        }

        return response()->json([
            $status
        ]);
    }
    public function getTableStatusNotPaid()
    {
        $tables = DB::table('orders')->where('status', '!=', 'paid')->get();

        return response()->json([
            'tables' => $tables
        ]);
    }

    
    // public function getOrderByTableNo($tableno){
        
    //     $orders = DB::table('order_details')
    //         ->select('order_details.id','orders.order_id','name','orderQty','order_details.status','orders.tableno','order_details.date_ordered','order_details.status')
    //         ->join('orders', 'orders.order_id', '=', 'order_details.order_id')
    //         ->join('menus','order_details.menuID','=','menus.menuID')
    //         ->where('orders.tableno', $tableno)
    //         ->where('order_details.status','!=','served')
    //         ->get(); 
            
    //         return response()->json([
    //             'details' => $orders
    //     ]);
            
    // }
    public function getOrderByTableNo($tableno){
        
        $orders = DB::table('kitchenrecords')
            ->select(
                'menus.name',
                'kitchenrecords.status',
                'kitchenrecords.orderQty',
                'kitchenrecords.id',
                'menus.price',
                'orders.order_id'
            )
            // ->join('order_details','order_details.id','=','kitchenrecords.orderDetailID')
            ->join('orders', 'orders.order_id', '=', 'kitchenrecords.order_id')
            ->join('menus', 'menus.menuID', '=', 'kitchenrecords.menuID')
            ->where('tableno', $tableno)
            ->where('kitchenrecords.status', '!=', 'served')
            ->orderBy('kitchenrecords.created_at', 'asc')->get();

        return response()->json([
            'orders' => $orders
        ]);
    }

    public function getCartItems($order_id)
    {
        $items = DB::table('carts')->get();

        return response()->json([
            'items' => $items
        ]);
    }

    public function beginTransaction(Request $request, $tableNo)
    {
       $id = 0; 

        $status = RestaurantTable::whereTableno($tableNo)->pluck('status')->first();

        if ($status == 'Occupied') {
            $order_id = Order::whereTableno($tableNo)
                ->where('status', 'ordering')
                ->pluck('order_id')->first();
            return response()->json([
                'order_id' => $order_id,
                'status' => $status
            ]);
        } 
        else if($status == 'Confirmed'){
            $customer = DB::table('customers')
        ->select('customers.custid')
        ->where('tableno',$tableNo)
        ->where('status','confirmed')
        ->get();

        foreach($customer as $c){
            $id = $c->custid;
        }
            $table = RestaurantTable::find($tableNo);
            $table->status = 'Occupied';
            $table->save();

            $newOrder = new Order;
            $newOrder->custid = $id;
            $newOrder->empid = $request->empid;
            $newOrder->tableno = $tableNo;
            $newOrder->status = 'ordering';
            $newOrder->total = 0;
            $newOrder->save();

            return response()->json([
                'order_id' =>  $newOrder->order_id
            ]);
        }
        else {
            $table = RestaurantTable::find($tableNo);
            $table->status = 'Occupied';
            $table->save();

            $newCustomer = Customer::create(['name' => 'cash']);
            $newOrder = new Order;
            $newOrder->custid = $newCustomer->custid;
            $newOrder->empid = $request->empid;
            $newOrder->tableno = $tableNo;
            $newOrder->status = 'ordering';
            $newOrder->total = 0;
            $newOrder->save();

            return response()->json([
                'order_id' =>  $newOrder->order_id
            ]);
        }
    }
}
