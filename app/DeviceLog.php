<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceLog extends Model
{
     use SoftDeletes;
    protected $primaryKey = 'id';
    protected $table = 'devicelogs';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = array('id','username','tableno','loggedin','loggedout');

    public function deviceloggedin(Request $request){
        $loggedin = new DeviceLog;
        $loggedin->name = $request->username;
        $loggedin->user_id = $request->user_id;
        $loggedin->tableno = $request->tableno;
        $loggedin->save();

        return response()->json([
            'message' => 'Device logged in!'
        ]);

    }

}
