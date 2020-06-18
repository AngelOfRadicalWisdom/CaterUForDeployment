<?php

use Illuminate\Database\Seeder;

class subcategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [

            [
                'subname'   => 'CHICKEN',
                'categoryid'=> 1
            ],
            [
                'subname'   => 'PORK',
                'categoryid'=> 1
            ],
            [
                'subname'   => 'SEAFOOD',
                'categoryid'=> 2
            ],
            [
                'subname'   => 'BEEF',
                'categoryid'=> 3
            ],
            [
                'subname'   => 'PORK',
                'categoryid'=> 4
            ],
            [
                'subname'   => 'PLAIN',
                'categoryid'=> 5
            ],
            [
                'subname'   => 'FRIED',
                'categoryid'=> 5
            ],
            [
                'subname'   => 'ICE CREAM',
                'categoryid'=> 6
            ],
            [
                'subname'   => 'SALAD',
                'categoryid'=> 6
            ],
            [
                'subname'   => 'NON ALOCHOLIC',
                'categoryid'=> 7
            ],
            [
                'subname'   => 'ALCOHOLIC',
                'categoryid'=> 7
            ],
];
        DB::table('sub_categories')->insert($subcategories);
    }
}
