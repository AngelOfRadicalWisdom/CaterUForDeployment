<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;

class AprioriNew
{

    public function __construct($samples, float $support = 0.0, float $confidence = 0.0)
    {
        $this->samples = $samples;
        $this->support = $support;
        $this->confidence = $confidence;
        $this->rules = [];
    }
      //$large set contains frequent k-length item sets.
      private $large=[];
    
    public function support($sample): float
    {
        return $this->frequency($sample) / count($this->samples);
    }
    public function confidence(array $set, array $subset): float
    {
        return $this->support($set) / $this->support($subset);
    }
    //Returns the items in the transaction
    private function items()
    {
        $items = [];
        //loops through the samples and checks if it already exist in the array
        //if true skips its then stores it in the variable $items
        foreach ($this->samples as $sample) {
            foreach ($sample as $item) {
                if (!in_array($item, $items, true)) {
                    $items[] = $item;
                }
            }
        }
        return array_map(function ($entry) {
            return [$entry];
        }, $items);
    }
    //Filters the most frequent menuID so that items that are bought less than the support are left with
    public function frequent($samples)
    {
        return array_values(array_filter($samples, function ($entry) {
            return $this->support($entry) >= $this->support;
        }));
    }
    //Count the number of transactions in which each items Occur
    public function frequency(array $sample): int
    {
        return count(array_filter($this->samples, function ($entry) use ($sample) {
            //check if the item is subset of the given sample
            return $this->subset($entry, $sample);
        }));
    }
    //checks if the given subset is a (proper) subet of the $samples. Returns true if it is, then false if its not
    private function subset(array $set, array $subset)
    {
        return count(array_diff($subset, array_intersect($subset, $set))) === 0;
    }
    //generates the apriori candidates 
    private function candidates(array $samples): array
    {
        $candidates = [];
        //for pairings
        foreach ($samples as $x) {
            foreach ($samples as $y) {
                //merge the pairings that are not the same
                if (count(array_merge(array_diff($x, $y), array_diff($y, $x))) != 2) {
                    //continue if !=2 because it means that there are still parings left
                    continue;
                }
                $candidate = array_values(array_unique(array_merge($x, $y)));
                //if pairs contains pair -> skip it
                if ($this->contains($candidates, $candidate)) {
                    continue;
                }
                //final candidates
                foreach ($this->samples as $sample) {
                    //check if its a proper subset
                    if ($this->subset($sample, $candidate)) {
                        $candidates[] = $candidate;
                        continue 2;
                    }
                }
            }
        }
        return $candidates;
    }
    //checks if the pair exist returns true if it exist 
    private function contains($system, $set)
    {
        return (bool) array_filter($system, function ($entry) use ($set) {
            return $this->equals($entry, $set);
        });
    }
    //generates the apriori pairings
    public function apriori()
    {
        $A = [];
        //get the frequent menus bought
        $items = $this->frequent($this->items());
        for ($k = 1; isset($items[0]); ++$k) {
            $A[$k] = $items;
            $items = $this->frequent($this->candidates($items));
        }
        return $A;
    }
    //Generate confidence rules for frequent item set.
    private function  generateRules($pair)
    {
        // move through all power sets
        foreach ($this->antecedents($pair) as $antecedent) {
            $confidence = $this->confidence($pair, $antecedent);
            if ($confidence >= $this->confidence) {
                $this->rules[] = [
                    'antecedent' => $antecedent,
                    'consequent' => array_values(array_diff($pair, $antecedent)),
                    'support'    => $this->support($pair),
                    'confidence' => $confidence,
                ];
            }
        }
    }
    // Generate rules for each k-length frequent item set.
    private function generateAllRules()
    {
        //k=2 to skip the original item sets
        //large is the set containing frequent k-length item sets 
        for ($k = 2; isset($this->large[$k]); ++$k) {
            foreach ($this->large[$k] as $frequent) {
                $this->generateRules($frequent);
            }
        }
    }
    //gets the rules generated
    public function getRules()
    {
        if (count($this->large) === 0) {
            $this->large = $this->apriori();
        }
        if (count($this->rules) > 0) {
            return $this->rules;
        }
        $this->rules = [];
        $this->generateAllRules();
        return $this->rules;
    }
    //Returns true if string representation of items does not differ.
    private function equals(array $set1, array $set2): bool
    {
        return array_diff($set1, $set2) == array_diff($set2, $set1);
    }


    // Generates all proper subsets for given set $sample without any empty set.
    private function antecedents(array $sample): array
    {
        $cardinality = count($sample);
        $antecedents = $this->powerSet($sample);
        return array_filter($antecedents, function ($antecedent) use ($cardinality) {
            return (count($antecedent) != $cardinality) && ($antecedent != []);
        });
    }
    //Generates the power set for given item set $sample or generates all subset sequence.
    private function powerSet(array $sample): array
    {
        $results = [[]];
        foreach ($sample as $item) {
            foreach ($results as $combination) {
                $results[] = array_merge([$item], $combination);
            }
        }
        return $results;
    }
    //Predicts the best antecedent or consequent (???)
    public function do_predict($sample)
    {
        $rules_related = array_values(array_filter($this->getRules(), function ($rule) use ($sample) {
            $antecedent = $rule['antecedent'];
            return array_diff($antecedent, $sample) == array_diff($sample, $antecedent);
        }));
        $consequents = array_map(function ($rule) {
            return $rule['consequent'];
        }, $rules_related);

        return $consequents;
    }
    //???
    public function getMenuCategoryID()
    {
        $menuCatID = DB::table('menus')->join('sub_categories', 'menus.subcatid', '=', 'sub_categories.subcatid')
            ->select('menus.menuID', 'sub_categories.subcatid', 'sub_categories.categoryid')
            ->get();
        return $menuCatID;
    }
}
