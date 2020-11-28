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
                'status'=>'AVAILABLE',
                'image'=>'CaterU.png',
                'name'=>'bundle 1'
            ],
            [
                'bundleid'  => 2,
                'price' => 451.00,
                'servingsize'=>3,
                'name' => 'Bundle2',
                'details'=>'bundle 2',
                'status'=>'AVAILABLE',
                'image'=>'CaterU.png',
                'name'=>'bundle 2'
            ],
            [
                'bundleid'  => 3,
                'price' => 600.00,
                'servingsize'=>4,
                'name' => 'Bundle3',
                'details'=>'bundle 3',
                'status'=>'AVAILABLE',
                'image'=>'CaterU.png',
                'name'=>'bundle 3'
            ],
            [
                'bundleid'  => 4,
                'price' => 1500.00,
                'servingsize'=>6,
                'name' => 'Bundle4',
                'details'=>'bundle 4',
                'status'=>'AVAILABLE',
                'image'=>'CaterU.png',
                'name'=>'bundle 4'
            ],
            [
                'bundleid'  => 5,
                'price' => 1000.00,
                'servingsize'=>5,
                'name' => 'Bundle5',
                'details'=>'bundle 5',
                'status'=>'AVAILABLE',
                'image'=>'CaterU.png',
                'name'=>'bundle 5'
            ],
            [
                'bundleid'  => 6,
                'price' => 900.00,
                'servingsize'=>3,
                'name' => 'Bundle6',
                'details'=>'bundle 6',
                'status'=>'AVAILABLE',
                'image'=>'CaterU.png',
                'name'=>'bundle 6'
            ],
            [
                'bundleid'  => 7,
                'price' => 500.00,
                'servingsize'=>4,
                'name' => 'Bundle7',
                'details'=>'bundle 7',
                'status'=>'AVAILABLE',
                'image'=>'CaterU.png',
                'name'=>'bundle 7'
            ],
            [
                'bundleid'  => 8,
                'price' => 750.00,
                'servingsize'=>5,
                'name' => 'Bundle8',
                'details'=>'bundle 8',
                'status'=>'AVAILABLE',
                'image'=>'CaterU.png',
                'name'=>'bundle 8'
            ],
        ];
        DB::table('bundles')->insert($bundleMenu);
    }
    }
