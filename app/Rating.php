<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;
    protected $table = 'ratings';
    protected $primaryKey = 'id';
    public $incrementing= true;
    public $timestamps = true;

    protected $fillable = ['id','star','created_at','updated_at'];
}
