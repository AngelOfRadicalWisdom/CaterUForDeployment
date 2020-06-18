<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
     use SoftDeletes;
    protected $table = 'categories';
    protected $primaryKey = 'categoryid';
    public $timestamps = false;
    public $incrementing = true;

    public function subcategory(){
        return $this->hasMany('App\SubCategory', 'categoryid', 'categoryid');
    }
    public function getCategoryId(Request $request){
        $categories = Category::find($request->categoryid);
        return $categories;
    }

}
