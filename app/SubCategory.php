<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    protected $table = 'sub_categories';
    protected $primaryKey = 'subcatid';
    public $timestamps = false;
    public $incrementing = true;


    // public function category(){
    //     return $this->hasOne(Category::class,'categoryid','categoryid');
    // }
    public function category(){
        return $this->belongsTo('App\Category', 'categoryid');
    }
    public function menu(){
        return $this->belongsTo('App\Menu','menuID');
    }
    
}
