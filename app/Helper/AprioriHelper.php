<?php

namespace App\Helper;

class AprioriHelper {

    private $samples;

    private $support;

    private $confidence;

    private $rules;

    public function __construct($samples, $support, $confidence) {
        $this->samples = $samples;
        $this->support = $support;
        $this->confidence = $confidence;
        $this->rules = [];

    }

    public function getSamples() {
        return $this->samples;
    }

    public function items() {
        $items = [];

        foreach($this->samples as $sample) {
            foreach($sample as $item) {
                if(!in_array($item, $items)) {
                 $items[] = $item;
                }
            }
        }

        return array_map(function($item) {
            return [$item];
        }, $items);
    }
    
   //Filters the most frequent menuID so that items that are bought less than the support are left with
    public function frequent($samples) {
        $filtered = array_filter($samples,function ($sample) {
            return $this->item_is_frequent($sample);
        });
        return $filtered;
    }

    public function item_is_frequent($sample) {
        //filter the samples with only the support of items >=support threshold
        return $this->support($sample)>= $this->support;
    }

    public function support($item) {
        // frequency / count(main sample)
        return $this->frequency($item)/count($this->samples);
    }
  //Count the number of transactions in which each items Occur
    public function frequency($item) {
        $contain_item = array_filter($this->samples, function ($sample) use ($item) {
            // if item is subset of sample
            return $this->subset($item, $sample);
        });
        return count($contain_item);
    }

    public function subset($sample, $item) {
       $intersect = array_intersect($sample, $item);
       $diff = array_diff($sample, $intersect);
       return count($diff) === 0;
    }
 //Makes the Pairs for every Item
 //self join rule
    public function possible_pairs($items) {
        $pairs = [];

        foreach($items as $x) {
            foreach($items as $y) {
                $diff1 = array_diff($x,$y);
                $diff2 = array_diff($y,$x);
                $merge = array_merge($diff1, $diff2);
                //!=2 beacause if the merge count doesn't reach 2 it means that there is no candidates or pairs created 
                if(count($merge) !== 2) {
                    continue;
                }

                $pair = array_values(array_unique(array_merge($x,$y)));

                //if pairs contains pair -> skip it
                if($this->iscontains($pairs,$pair)) {
                    continue;
                }
                //parr($pair);
                //parr($this->samples);
                foreach($this->samples as $sample) {
                    if($this->subset($pair,$sample)) {
                        $pairs[] = $pair;
                        continue 2;
                    }
                }
            }
        }

        return $pairs;
    }
   //checks if the pair exist
    private function iscontains($pairs, $pair) {
        $filtered = array_filter($pairs, function($entry) use ($pair) {
            return array_diff($entry,$pair) == array_diff($pair,$entry);
        });

        return (bool) $filtered;
    }

    public function all_pairs() {
        //generates the apriori Pairings
        $A = [];
      //Step 1:: Apply minimum Support  to find all the frequent sets with K items in the database
        $items = $this->frequent($this->items());
        for($k=1; isset($items[0]);++$k) {
            $A[$k] = $items;
            $items = $this->frequent($this->possible_pairs($items));
        }

        return $A;
    }

    public function get_rules() {
        if(count($this->rules) > 0) {
         
            return $this->rules;
        }
        $this->generate_all_rules();
        return $this->rules;
    }

    public function generate_all_rules() {
        $A = $this->all_pairs();

        for($k=2; isset($A[$k]); ++$k) {
            foreach($A[$k] as $frequent_pair) {
                $this->create_pair_rules($frequent_pair);
            }
        }
    }

    public function create_pair_rules($pair) {
        // move through all power sets
        foreach($this->antecedents($pair) as $antecedent) {
            $confidence = $this->confidence($pair, $antecedent);
            if($confidence >= $this->confidence) {
                $this->rules[] = [
                    'antecedent' => $antecedent,
                    'consequent' => array_values(array_diff($pair, $antecedent)),
                    'support'    => $this->support($pair),
                    'confidence' => $confidence,
                ];
            }
        }
    }

    public function confidence($set, $subset) {
        return $this->support($set) / $this->support($subset);
    }

    private function antecedents($sample) {
        $count = count($sample);
        $results = [[]];
        foreach($sample as $item) {
            foreach($results as $combination) {
                $results[] = array_merge([$item], $combination);
            }
        }
        $antecedents = array_filter($results, function ($result) use ($count) {
            return ($result != [] && count($result) != $count);
        });
        return $antecedents;
    }

    public function predict($samples) {
        if(!is_array($samples[0])) {
            return $this->do_predict($samples);
        }

      //  $predictions = [];
        foreach($samples as $i => $sample) {
          //  $predictions[$i] = $this->do_predict($sample);
          $predictions=$this->do_predict($sample);
        }
        foreach($predictions as $predict){
           (object) $p[]=(object)$predict;
          // $p=arra($predict);
        }
       // return (object)$p;
       return (object)array("menuID"=>$p);
      //return $predictions;
    }

    public function do_predict($sample) {
        $rules_related = array_values(array_filter($this->get_rules(), function($rule) use ($sample) {
            $antecedent = $rule['antecedent'];
            return array_diff($antecedent,$sample) == array_diff($sample,$antecedent);
        }));
//parr($rules_related);
        $consequents = array_map(function($rule) {
            return $rule['consequent'];
        },$rules_related);

        return $consequents;
    }
public function getMenuCategoryID(){
    $menuCatID=DB::table('menus')->join('sub_categories','menus.subcatid','=','sub_categories.subcatid')
    ->select('menus.menuID','sub_categories.subcatid','sub_categories.categoryid')
    ->get();
    return $menuCatID;
}

function parr($arr) {
    echo "<pre>";
    print_r(json_encode($arr));
    echo "</pre>";
}
}