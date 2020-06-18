<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Log extends Model
{
    use SoftDeletes;
    protected $table = 'devicelogs';
    protected $primaryKey = 'id';
    public $incrementing= true;
    public $timestamps = true;

    const CREATED_AT = 'loggedin';
    const UPDATED_AT = 'loggedout';

    protected $fillable = array('id','session_id','loggedin','loggedout');
    
}
