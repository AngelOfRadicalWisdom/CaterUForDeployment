<?php
declare(strict_types=1);

namespace App\Http\Controllers;
//namespace Phpml\Association;
// use Phpml\Helper\Predictable;
// use Phpml\Helper\Trainable;
use App\Helper\AprioriHelper;
use App\Helper\AprioriNew;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Response;
use App\Apriori;
use App\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AprioriC2Controller extends Controller 
{
    public function generateAprioriPage(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        $samples=$this->getTransactions();
        $sc=$this->getSupportandConfidence();
        if(count($sc)==0){
            $support='';
            $confidence='';
            $support=75/100;
            $confidence=75/100;
        }
        else{
            $support='';
            $confidence='';
            foreach($sc as $row){
            $support=$row->support/100;
            $confidence=$row->confidence/100;
            }
        }
        // $apriori = new AprioriHelper($samples, $support, $confidence);
        $apriori = new AprioriNew($samples, $support, $confidence);
        $allMenus = Menu::all();
        $ItemSets=DB::table('apriori')
        ->selectRaw('COUNT(menuID) as count')
        ->groupBy('groupNumber')
        ->distinct()
        ->get();
        $suggestedMenus = DB::table('apriori')
        ->join('menus','apriori.menuID','=','menus.menuID')
       ->selectRaw('group_concat(menus.menuID) as menuID')
       //->select('group_concat(bundle_menus.menuID)','menus.name')
     //   ->select('bundle_menus.bundleGroup','menus.name','bundle_menus.bundleGroup')
        ->groupBy('apriori.groupNumber')
        ->get();
        $result = [];
        foreach($suggestedMenus as $row) {
            $result[] = explode(',',$row->menuID);
        }
          $sMenus=array_values($result);
          $count = DB::table('apriori')
       ->selectRaw('group_concat(menuID) as menuID')
        ->groupBy('apriori.groupNumber')
        ->get();
        if(count($count)==0){
            $frequentCount=0;
            return view('admin.generateApriori',compact('frequentCount','userImage','userFname','userLname','allMenus','sMenus','ItemSets'));
        }
        else{
        foreach($count as $pairingCount){
            $frequentMenus[]=explode(',',$pairingCount->menuID);
            for($i=0;$i<count($frequentMenus);$i++){
             $frequentCount[]=$apriori->frequency($frequentMenus[$i]);
        }
              
          }
      
          return view('admin.generateApriori',compact('frequentCount','userImage','userFname','userLname','allMenus','sMenus','ItemSets'));

    }
}

    public function GenerateRecommendations() {
        $samples=$this->getTransactions();
        $sc=$this->getSupportandConfidence();
        if(count($sc)==0){
            $support='';
            $confidence='';
            $support=75/100;
            $confidence=75/100;
            //$apriori = new AprioriHelper($samples, $support, $confidence );
            $apriori = new AprioriNew($samples, $support, $confidence );
            $pairs = $apriori->apriori();
            $this->addPairs($pairs);                    
            
    }
        else{
        $support='';
        $confidence='';
        foreach($sc as $row){
        $support=$row->support/100;
        $confidence=$row->confidence/100;
        }
      //  $apriori = new AprioriHelper($samples, $support, $confidence );
      $apriori = new AprioriNew($samples, $support, $confidence );
    
        // $samples = [
        //     ['Onion', 'Potato','Burger'],
        //     ['Potato','Burger', 'Milk'],
        //     ['Milk','Beer'],
        //     ['Onion', 'Potato', 'Milk'],
        //     ['Onion', 'Potato','Burger','Beer'],
        //     ['Onion', 'Potato','Burger', 'Milk'],
        // ];
      //  $samples=$this->getTransactions();
        //$apriori = new Apriori($samples, 0.50, 0.50 );
        //$this->parr($apriori->get_rules());
        $pairs = $apriori->apriori();
      //  $this->generateAprioriPage($pairs);

       // echo($pairs);
       // print_r($pairs);
  //    $this->parr($pairs);
        // $this->addPairs($pairs);
      //  print_r($this->sendApriori());

        // foreach($pairs as $pair) {
        //     $this->parr($pair);
        // }
        //$t=$apriori->predict($tests);
   //  dd($this->pairs);
        }
      //  return redirect('/generateapr');
        return $pairs;
    }

    public function addPairs() {
        $pairs=$this->GenerateRecommendations();
        $checkDB=DB::table('apriori')->get();
        if($checkDB==NULL){
        $groupNumber = 0;
        for($i=2;$i<=count($pairs);$i++) {
            foreach($pairs[$i] as $group_number) {
                ++$groupNumber;
                foreach($group_number as $menu_id) {
                    $row = array('menuID'=>$menu_id,'groupNumber'=>$groupNumber);
                    $this->addBundleRow($row);
                }
            }
        }
    }
    else{
        DB::table('apriori')->truncate();
        $groupNumber = 0;
        for($i=2;$i<=count($pairs);$i++) {
            foreach($pairs[$i] as $group_number) {
                ++$groupNumber;
                foreach($group_number as $menu_id) {
                    $row = array('menuID'=>$menu_id,'groupNumber'=>$groupNumber);
                    $this->addBundleRow($row);
                }
            }
        }

    }
    return redirect('/generateapr');
   
}

    private function addBundleRow($row) {
        DB::table('apriori')->insert($row);
    }

    private function parr($arr) {
        echo "<pre>";
        print_r(json_encode($arr));
        echo "</pre>";
    }

    private function getTransactions() {
        // $order_menu =DB::table('order_details')->select('order_id','menuID')->get();
        // //$this->parr($order_menu);
        // $transactions=[];
        // foreach($order_menu as $row){
        //     $transactions[$row->order_id][] = $row->menuID;
        // }
        // return array_values($transactions);
       // $order_menu=DB::table('order_details')->select(DB::raw('group_concat(menuID) as menu')->groupBy('flag')->get();
       /*$order_menu = DB::raw_plan()
                                ->select('order_details.*', DB::raw('group_concat(name) as names'))
                                ->where('assignment_id', 1)
                                ->groupBy('flag')
                                ->get();*/
        $transactions = DB::table('order_details')
                            ->select(DB::raw('group_concat(menuID) as transaction'))
                            ->groupBy('order_id')
                            ->orderBy('order_id')
                            ->get();
        //$this->parr($transactions);
        $result = [];
        foreach($transactions as $row) {
            $result[] = explode(',',$row->transaction);
        }
        return array_values($result);
      
    }
    private function getSupportandConfidence(){
        $sc=DB::table('aprioriSettings')->get();
        return $sc;
     }

         public function sendApriori($menuId){
        $menu = [];
        $groupedData = [];
       
        $transactions = DB::table('apriori')
            ->join('menus','apriori.menuID','=','menus.menuID')
            ->selectRaw('group_concat(menus.name) as name')
            ->selectRaw('group_concat(menus.menuID) as menuID') 
            ->selectRaw('group_concat(menus.image) as image')
            ->groupBy('apriori.groupNumber')
            ->havingRaw('menuID',[$menuId])
            ->get();
      

        foreach($transactions as $row){
            $menu[]=explode(",",$row->menuID);
        }
        for($index=0;$index<count($menu);$index++){
            foreach($menu[$index] as $Smenus){
                if($Smenus != $menuId){
                  $groupedData[]=$Smenus;
                }
            }
        }
        $final = array_unique($groupedData);
        $groupedData = [];
        $data;
        foreach($final as $row){
            $data = DB::table('menus')->where('menuID',$row)->get();
            array_push($groupedData,$row);
        }
        $data = [];
        for($i = 0; $i < count($groupedData) ; $i++){
            $t = DB::table('menus')->where('menuID',$groupedData[$i])->get();   
          
           foreach( $t as $a ){
                array_push($data, array(
                    'name' => $a->name,
                    'menuID' => $a->menuID,
                    'image' => asset('/menu/menu_images/'.$a->image),
                ));
           }
           
        }

     return response()->json(['menu'=>$data]);
     }

     public function sendPredict(Request $request){

     }


}
