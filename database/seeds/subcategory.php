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
                'subcatid' => 1,
                'subname'   => 'CHICKEN',
                'categoryid'=> 1
            ],
            [
                'subcatid' => 2,
                'subname'   => 'PORK',
                'categoryid'=> 1
            ],
            [
                'subcatid' => 3,
                'subname'   => 'SEAFOOD',
                'categoryid'=> 2
            ],
            [
                'subcatid' => 4,
                'subname'   => 'BEEF',
                'categoryid'=> 3
            ],
            [
                'subcatid' => 5,
                'subname'   => 'PORK',
                'categoryid'=> 4
            ],
            [
                'subcatid' => 6,
                'subname'   => 'PLAIN',
                'categoryid'=> 5
            ],
            [
                'subcatid' => 7,
                'subname'   => 'FRIED',
                'categoryid'=> 5
            ],
            [
                'subcatid' => 8,
                'subname'   => 'ICE CREAM',
                'categoryid'=> 6
            ],
            [
                'subcatid' => 9,
                'subname'   => 'SALAD',
                'categoryid'=> 6
            ],
            [
                'subcatid' => 10,
                'subname'   => 'NON ALOCHOLIC',
                'categoryid'=> 7
            ],
            [
                'subcatid' => 11,
                'subname'   => 'ALCOHOLIC',
                'categoryid'=> 7
            ],
];
        DB::table('sub_categories')->insert($subcategories);
    }
}
