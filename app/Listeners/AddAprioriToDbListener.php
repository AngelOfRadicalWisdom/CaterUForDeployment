<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\AprioriProcessEvent;
use App\Helper\AprioriNew;
use Illuminate\Support\Facades\Auth;
use App\Menu;
use Illuminate\Support\Facades\DB;
class AddAprioriToDbListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $this->addPairs();
    }
    //getting all of the transactions
    private function getTransactions()
    {
        try{
        $transactions = DB::table('order_details')
            ->select(DB::raw('group_concat(menuID) as transaction'))
            ->groupBy('order_id')
            ->orderBy('order_id')
            ->get();
        $result = [];
        foreach ($transactions as $row) {
            $result[] = explode(',', $row->transaction);
        }
        return array_values($result);
    }
    catch (\PDOException $e) {
        return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
    }
    }
    //getting the support and confidence
    private function getSupportandConfidence()
    {
        $sc = DB::table('aprioriSettings')->get();
        return $sc;
    }
     //generating recommendations function
     public function GenerateRecommendations()
     {
         try{
         $samples = $this->getTransactions();
         $sc = $this->getSupportandConfidence();
         if (count($sc) == 0) {
             $support = '';
             $confidence = '';
             $support = 75 / 100;
             $confidence = 75 / 100;
             $apriori = new AprioriNew($samples, $support, $confidence);
             $pairs = $apriori->apriori();
         } else {
             $support = '';
             $confidence = '';
             foreach ($sc as $row) {
                 $support = $row->support / 100;
                 $confidence = $row->confidence / 100;
             }
             $apriori = new AprioriNew($samples, $support, $confidence);
             $pairs = $apriori->apriori();
         }
         return $pairs;
     }
     catch (\PDOException $e) {
         return back()->withError("Sorry Something Went Wrong Please check your inputs")->withInput();
     }
     }
     //insert function 
     private function addBundleRow($row)
     {
         DB::table('apriori')->insert($row);
     }
    private function addPairs(){
        $pairs = $this->GenerateRecommendations();
$checkDB = DB::table('apriori')->get();
        if ($checkDB == NULL) {
            $groupNumber = 0;
            for ($i = 2; $i <= count($pairs); $i++) {
                foreach ($pairs[$i] as $group_number) {
                    ++$groupNumber;
                    foreach ($group_number as $menu_id) {
                        $row = array('menuID' => $menu_id, 'groupNumber' => $groupNumber);
                        $this->addBundleRow($row);
                    }
                }
            }
        } else {
            DB::table('apriori')->truncate();
            $groupNumber = 0;
            for ($i = 2; $i <= count($pairs); $i++) {
                foreach ($pairs[$i] as $group_number) {
                    ++$groupNumber;
                    foreach ($group_number as $menu_id) {
                        $row = array('menuID' => $menu_id, 'groupNumber' => $groupNumber);
                        $this->addBundleRow($row);
                    }
                }
            }
        }
    }
}
