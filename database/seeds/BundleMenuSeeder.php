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
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => '2',
                'price' => '451',
                'servingsize'=>'3',
                'details'=>'bundle 2',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => '3',
                'price' => '600',
                'servingsize'=>'4',
                'details'=>'bundle 3',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => '4',
                'price' => '1500',
                'servingsize'=>'6',
                'details'=>'bundle 4',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => '5',
                'price' => '1000',
                'servingsize'=>'5',
                'details'=>'bundle 5',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => '6',
                'price' => '900',
                'servingsize'=>'3',
                'details'=>'bundle 6',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => '7',
                'price' => '500',
                'servingsize'=>'4',
                'details'=>'bundle 7',
                'image'=>'CaterU.png'
            ],
            [
                'bundleid'  => '8',
                'price' => '750',
                'servingsize'=>'5',
                'details'=>'bundle 8',
                'image'=>'CaterU.png'
            ],
        ];
        DB::table('customers')->insert($bundleMenu);
    }
    }
