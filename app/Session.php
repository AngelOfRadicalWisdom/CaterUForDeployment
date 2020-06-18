<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public function getSessionUserId($userid){
        return $id = DB::table('sessions')->where('user_id',$userid)->get();
    }
}
