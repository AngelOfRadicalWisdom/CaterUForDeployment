<?php

use Illuminate\Database\Seeder;

class category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
        
            [
                'categoryid'=>1,
                'categoryname'=> 'Barbecue Classics',
                'description' => 'All about Barbecue'
            ],
            [
                'categoryid'=>2,
                'categoryname'=> 'Appetizers',
                'description' => 'Bon Apetit'
            ],
            [
                'categoryid'=>3,
                'categoryname'=> 'Beef',
                'description' => 'Beef Menus'
            ],
            [
                'categoryid'=>4,
                'categoryname'=> 'Pork',
                'description' => 'Loriem Ipsum'
            ],
            [
                'categoryid'=>5,
                'categoryname'=> 'Rice',
                'description' => 'Loriem Ipsum'
            ],
            [
                'categoryid'=>6,
                'categoryname'=> 'Dessert',
                'description' => 'Loriem Ipsum'
            ],
            [
                'categoryid'=>7,
                'categoryname'=> 'Drinks',
                'description' => 'Loriem Ipsum'
            ],
        ];
        DB::table('categories')->insert($categories);
    }
}
