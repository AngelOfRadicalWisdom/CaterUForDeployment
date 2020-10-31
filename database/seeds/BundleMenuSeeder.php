<?php

use Illuminate\Database\Seeder;

class BundleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bundleMenu = [
            [
                'bundleid'  => 1,
                'price' => 265.00,
                'servingsize'=> 2,
                'name' => 'Bundle1',
                'details'=>'bundle 1',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => 2,
                'price' => 451.00,
                'servingsize'=>3,
                'name' => 'Bundle2',
                'details'=>'bundle 2',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => 3,
                'price' => 600.00,
                'servingsize'=>4,
                'name' => 'Bundle3',
                'details'=>'bundle 3',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => 4,
                'price' => 1500.00,
                'servingsize'=>6,
                'name' => 'Bundle4',
                'details'=>'bundle 4',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => 5,
                'price' => 1000.00,
                'servingsize'=>5,
                'name' => 'Bundle5',
                'details'=>'bundle 5',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => 6,
                'price' => 900.00,
                'servingsize'=>3,
                'name' => 'Bundle6',
                'details'=>'bundle 6',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => 7,
                'price' => 500.00,
                'servingsize'=>4,
                'name' => 'Bundle7',
                'details'=>'bundle 7',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => 8,
                'price' => 750.00,
                'servingsize'=>5,
                'name' => 'Bundle8',
                'details'=>'bundle 8',
                'image'=>'CaterU.png'
            ],
        ];
        DB::table('bundles')->insert($bundleMenu);
    }
    }
