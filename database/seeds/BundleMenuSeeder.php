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
                'bundleid'  => '1',
                'price' => '265',
                'servingsize'=>'2',
                'details'=>'bundle 1',
                'image'=>'CaterU.png',
                'name'=>'bundle 1'
            ],
            [
                'bundleid'  => '2',
                'price' => '451',
                'servingsize'=>'3',
                'details'=>'bundle 2',
                'image'=>'CaterU.png',
                'name'=>'bundle 2'
            ],
            [
                'bundleid'  => '3',
                'price' => '600',
                'servingsize'=>'4',
                'details'=>'bundle 3',
                'image'=>'CaterU.png',
                'name'=>'bundle 3'
            ],
            [
                'bundleid'  => '4',
                'price' => '1500',
                'servingsize'=>'6',
                'details'=>'bundle 4',
                'image'=>'CaterU.png',
                'name'=>'bundle 4'
            ],
            [
                'bundleid'  => '5',
                'price' => '1000',
                'servingsize'=>'5',
                'details'=>'bundle 5',
                'image'=>'CaterU.png',
                'name'=>'bundle 5'
            ],
            [
                'bundleid'  => '6',
                'price' => '900',
                'servingsize'=>'3',
                'details'=>'bundle 6',
                'image'=>'CaterU.png',
                'name'=>'bundle 6'
            ],
            [
                'bundleid'  => '7',
                'price' => '500',
                'servingsize'=>'4',
                'details'=>'bundle 7',
                'image'=>'CaterU.png',
                'name'=>'bundle 7'
            ],
            [
                'bundleid'  => '8',
                'price' => '750',
                'servingsize'=>'5',
                'details'=>'bundle 8',
                'image'=>'CaterU.png',
                'name'=>'bundle 8'
            ],
        ];
        DB::table('bundles')->insert($bundleMenu);
    }
    }
