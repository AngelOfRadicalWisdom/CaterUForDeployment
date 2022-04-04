<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Menu extends Model
{
    use SoftDeletes;
    protected $table = 'menus';
    protected $primaryKey = 'menuID';    
    public $incrementing = true;
    public $timestamps = false;


    ////protected $fillable = array('menuID','name','details','price','servingsize','size','image','subcatid');
    protected static $rules = [
        'menuID' => ['required', 'unique:cater.menus,menuID'],
        'name' => ['required', 'regex: /[A-z\s-]+$/'],
        'details' => ['required', 'regex: /[A-z\s-]+$/'],
        
        'price' => 'required',
        'servingsize' => ['required','regex:/^[-+]?\d*$/','min:1']
       
    ];

    protected static $messages = [
        'menuID.required' => "The employee id should not be empty.",
        'menuID.unique' => "The id entered already exists in the database.",
        'name.required' => "The first name should not be empty.",
        'name.regex' => "Only alphabetic, spaces, and dashes are accepted.",
        'details.regex' => "Only alphabetic, spaces, and dashes are accepted.",
        'price.required' => "Price should not be empty.",
       
    ];

    public function subcategory()
    {
        return $this->hasOne(SubCategory::class, 'subcatid', 'subcatid');
    }
    public function orderdetail(){
        return $this->belongsTo('App\OrderDetail','menuID','menuID');
    }

    public static function getMenuValidationRules($type)
    {
        if ($type === 'insert')
            return self::$rules;
        if ($type === 'update') {
            array_shift(self::$rules);
            return self::$rules;
        }
    }

    public static function getMenuValidationMessages($type)
    {
        if ($type === 'insert')
            return self::$messages;
        if ($type === 'update') {
            array_shift(self::$messages);
            return self::$messages;
        }
    }
    public function getSumQty($menuID){
        return DB::table('order_details')->where('menuID',$menuID)->where('status','served')->sum('orderQty');
    }
    public function getTotal($menuID){
        return DB::table('order_details')->where('menuID',$menuID)->where('status','served')->sum('subtotal');
    }
}
