<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\AprioriTraits;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Response;
use App\Http\OrderDetail;
use Phpml\Helper\Predictable;
use Phpml\Helper\Trainable;
use App\Helper\Apriori2;
use Illuminate\Support\Collection;

class RecAprioriController extends Controller 
{
    //
//     use AprioriTraits;
  
//     public const ARRAY_KEY_ANTECEDENT = 'antecedent';
//     public const ARRAY_KEY_CONFIDENCE = 'confidence';
//     public const ARRAY_KEY_CONSEQUENT = 'consequent';
//     public const ARRAY_KEY_SUPPORT = 'support';
//     /**
//      * Minimum relative probability of frequent transactions.
//      *
//      * @var float
//      */
//     private $confidence;
//     /**
//      * The large set contains frequent k-length item sets.
//      *
//      * @var mixed[][][]
//      */
//     private $large = [];
//     /**
//      * Minimum relative frequency of transactions.
//      *
//      * @var float
//      */
//     private $support;
//     /**
//      * The generated Apriori association rules.
//      *
//      * @var mixed[][]
//      */
//     private $rules = [];
//     /**
//      * Apriori constructor.
//      */
//     public function __construct(float $support = 0.0, float $confidence = 0.0)
//     {
//         $this->support = $support;
//         $this->confidence = $confidence;
//     }
//     private function frequency(array $sample)
//     {
       
//     //    return count(array_filter($sample, $this->subset($sample,$entry)));

//     //    }
//     $min=array(min($sample));
//     $entry=array_filter(array_diff($sample,$min));
//     // return (array_filter($sample, function ($entry) use ($sample) {
//     //     $min=array(min($sample));
//     //     $entry=array_filter(array_diff($sample,$min));
//     //     return $this->subset($entry, $sample);
//         return $entry;
//    // }));
// }
    
//     private function subset(array $set, array $subset)
//     {
//     //     if(array_diff($subset, array_intersect($subset, $set))) ==NULL){
//     //         return true
//     //     }
//     //    // $req=(array_diff($subset, array_intersect($subset, $set))) === 0;
//     //     return ($req);
//     return array_diff($subset, array_intersect($subset, $set));
//     }
//     private function support(array $sample): float
//     {
//       //  for(cv)
//         //'return $this->frequency($sample) / count($sample);
//     }

//     public function getData(){
//         $order_id =DB::table('order_details')->select('order_id','menuID')->get();
//         return $order_id;
//     }
    
//     public function frequentMenus($array){
//      //$parray=array();
//         foreach($array as $keys=>$value){
//           $mkeys[]=$keys;
//           $mvalues[]=$value;
//         }
//         return $final = ['menuId' => $mkeys,'count'=>$mvalues];
//     }
   
   
//     public function RecAp(Request $request){
//         $order_id =DB::table('order_details')->select('order_id','menuID')->get();
// // $order_id=$this->getdata();
// // $order=[];
// //  foreach($order_id as $orders){
// //   $order[]=$orders->menuID;
// //    }
// // $tableOrders1=$this->array_icount_values($order);
// // $tableOrders=$this->frequency($tableOrders1);
// // //print_r($tableOrders1);
// // foreach($tableOrders as $key=>$values){
// //    // print_r($key);
    
// // }
// // //print_r($order_id);
// // //print_r($tableOrders);
// // print_r($tableOrders1);
// $order=DB::table('orders')->select('order_id')->get();
// foreach($order_id as $orders){
//     foreach($order as $transaction){
//         if($orders->order_id===$transaction->order_id){
//             $torder[]=$orders->menuID;
//             $count=count($order);
            
//     }
// }
// //$transaction2=DB::table('order_details')->pluck('menuID');
// count($order);

// }
// //print_r($torder);
// echo "<pre>";
// print_r($count);
// echo "</pre>";


//     }
public function RecAp(Request $request) {
    $samples = [
        ['Onion', 'Potato','Burger'],
        ['Potato','Burger', 'Milk'],
        ['Milk','Beer'],
        ['Onion', 'Potato', 'Milk'],
        ['Onion', 'Potato','Burger','Beer'],
        ['Onion', 'Potato','Burger', 'Milk','Beer'],
    ];

    $apriori = new Apriori2($samples, 0.50);
    $this->parr($apriori->frequent($apriori->items()));
    $this->parr($samples);
    $this->parr($apriori->items());
    $this->parr($apriori->apriori());
    $this->parr($apriori->powerSet($samples));
    $this->parr($apriori->antecedents($samples));
    $this->parr($apriori->generateAllRules());
    print_r($apriori->predictSample($samples));
    
    

    
}

private function parr($arr) {
    echo "<pre>";
    print_r(json_encode($arr));
    echo "</pre>";
}

private function getTransactions() {
    //$order_id =DB::table('order_details')->select('order_id','menuID')->get();
   // $order_id=$this->getdata();
    $order=[];
    foreach($order_id as $orders){
      $order[]=$orders->menuID;
    }
   // $tableOrders1=$this->array_icount_values($order);
   // $tableOrders=$this->frequency($tableOrders1);
    //print_r($tableOrders1);
    foreach($tableOrders as $key=>$values){
       // print_r($key);
        
    }

     //print_r($order_id);
    //print_r($tableOrders);
    print_r($tableOrders1);
}
    
}