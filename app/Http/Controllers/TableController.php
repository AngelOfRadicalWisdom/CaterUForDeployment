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
    private $customExceptions;

    public function __construct(CustomExceptions $customExceptions)
    {
        $this->customExceptions = $customExceptions;
    }
    public function tableList(){
       $allTables = RestaurantTable::all();
        return response()->json(['allTables'=> $allTables]);
    }

    public function webTableList(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $allTables = RestaurantTable::all();
         return view('admin.tablelist',compact('userImage','allTables','userFname','userLname'));
     }

    public function getAvailableTable(){
        $availableTables = DB::table('tables')->where('status','Available')->get();

        return response()->json([
            'AvailableTables' => $availableTables
        ]);
    }
    public function getOccupiedTable(){
        $occupiedTables = DB::table('tables')->where('status','Occupied')->get();

        return response()->json([
            'OccupiedTables' => $occupiedTables
        ]);
    }

    public function newTable(){
    $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        return view('addtables',compact('userImage','userFname','userLname'));

    }
    public function addTable(Request $request){
        try{
            $table=$this->customExceptions->AddTable($request);
          }
          catch(\PDOException $e){
            return back()->withError($e->getMessage())->withInput();
          }
        $table = new RestaurantTable;
        $table->tableno=$request->tablenum;
        $table->capacity = $request->capacity;
        $table->status = $request->status;

        $table->save();

        return redirect('/table/tablelist')->with('success','Table Successfully Created')->withInput();
    }

public function removeTable($tableno){
    $Table= RestaurantTable::find($tableno);

    if ($Table) {
        $Table->delete();
    }

    return \Response::json(['status' =>200,'error'=>""]);
}
    public function editTable(Request $request,$tableno=null){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $tables = RestaurantTable::where(['tableno'=>$tableno])->first();
       if($request->isMethod('post')){
           $data= $request->all();
           try{
            $table=$this->customExceptions->EditTable($request);
          }
          catch(\PDOException $e){
            return back()->withError($e->getMessage())->withInput();
          }
           RestaurantTable::where(['tableno'=>$tableno])
            ->update(['tableno'=>$data['tablenum'],'capacity' =>$data['capacity'],'status'=>$data['status']]);
    
            return redirect('/table/tablelist')->with('success','Table Successfully Updated');
       }
      // dd($currentCategory->categoryid);
     return view('edit_tables')->with(compact('userImage','tables','userFname','userLname'));
    }
    public function requestTableTransfer($order_id,Request $request){
        $table = Table::find($request->tableno);
        if($table->status == 'occupied'){
            return response()->json([
                'error_message' => 'The table'.$table.'is not Avaible'
            ]);
        }else{
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
        if($table->status =='Available'){
            $table->status = 'Occupied';
        }
        
        $table->save();

        return response()->json([
            'message' => 'Table is set'
        ]);
    }

    public function setTableAvailable($tableno){
        $table = RestaurantTable::find($tableno);
        $table->status = 'Available';
        $table->save();

        return response()->json([
            'message' => 'Table is set to available'
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

    public function clearTable(Request $request){
        $table = RestaurantTable::find($request->tableno);
        $table->status = 'Available';
        $table->save();

        return response()->json([
            'message' => 'Table Cleared'
        ]);
    }


    public function setDeviceTable(Request $request){
            $message = '';

            $table=RestaurantTable::find($request->tableno);
            if($table->status != 'Occupied'){
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
        if($table->status == 'Available'){
            $status = 'Available';
        } else{
            $status = 'Occupied';
        }

        return response()->json([
           $status
        ]);

    }
    public function getTableStatusNotPaid(){
        $tables = DB::table('orders')->where('status','!=','paid')->get();
        
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
        ->select('menus.name','kitchenrecords.status','kitchenrecords.orderQty','kitchenrecords.id'
        ,'menus.price','orders.order_id')
        // ->join('order_details','order_details.id','=','kitchenrecords.orderDetailID')
        ->join('orders','orders.order_id','=','kitchenrecords.order_id')
        ->join('menus','menus.menuID','=','kitchenrecords.menuID')
        ->where('tableno',$tableno)
        ->where('kitchenrecords.status','!=','served')
        ->orderBy('kitchenrecords.created_at','asc')->get();
 
         return response()->json([
             'orders' => $orders
         ]);
    
            
    }

    public function getCartItems($order_id){
        $items = DB::table('carts')->get();

        return response()->json([
            'items' => $items
        ]);

    }

    public function beginTransaction(Request $request, $tableNo){

        $status = RestaurantTable::whereTableno($tableNo)->pluck('status')->first();
        
        if($status == 'Occupied'){
            $order_id = Order::whereTableno($tableNo)
        ->where('status','ordering')
        ->pluck('order_id')->first();
         return response()->json([
             'order_id' => $order_id,
             'status' => $status
         ]);
        }else{
            $table = RestaurantTable::find($tableNo);
            $table->status = 'Occupied';
            $table->save();

        $newCustomer = Customer::create(['name'=>'cash']);
        $newOrder = new Order;
        $newOrder->custid= $newCustomer->custid;
        $newOrder->empid=$request->empid;
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
