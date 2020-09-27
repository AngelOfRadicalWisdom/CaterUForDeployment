<?php

use Illuminate\Database\Seeder;

class BundleDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $bundleMenu = [
            [
                'menuID'=>3,
                'qty' => 3,
                'bundleid'=>1,
            ],
            [
                'menuID'=>5,
                'qty' => 3,
                'bundleid'=>1,
            ],
            [
                'menuID'=>18,
                'qty' => 3,
                'bundleid'=>1,
            ],
            [
                'menuID'=>24,
                'qty' => 3,
                'bundleid'=>1,
            ],
            [
                'menuID'=>3,
                'qty' => 3,
                'bundleid'=>2,
            ],
            [
                'menuID'=>8,
                'qty' => 3,
                'bundleid'=>2,
            ],
            [
                'menuID'=>19,
                'qty' => 3,
                'bundleid'=>2,
            ],
            [
                'menuID'=>3,
                'qty' => 3,
                'bundleid'=>3,
            ],
            [
                'menuID'=>2,
                'qty' => 3,
                'bundleid'=>3,
            ],
            [
                'menuID'=>17,
                'qty' => 3,
                'bundleid'=>3,
            ],
            [
                'menuID'=>15,
                'qty' => 3,
                'bundleid'=>3,
            ],
            [
                'menuID'=>3,
                'qty' => 3,
                'bundleid'=>4,
            ],
            [
                'menuID'=>14,
                'qty' => 3,
                'bundleid'=>4,
            ],
            [
                'menuID'=>19,
                'qty' => 3,
                'bundleid'=>4,
            ],
            [
                'menuID'=>3,
                'qty' => 3,
                'bundleid'=>5,
            ],
            [
                'menuID'=>16,
                'qty' => 3,
                'bundleid'=>5,
            ],
            [
                'menuID'=>12,
                'qty' => 3,
                'bundleid'=>5,
            ],
            [
                'menuID'=>3,
                'qty' => 3,
                'bundleid'=>6,
            ],
            [
                'menuID'=>20,
                'qty' => 3,
                'bundleid'=>6,
            ],
            [
                'menuID'=>9,
                'qty' => 3,
                'bundleid'=>6,
            ],
            [
                'menuID'=>18,
                'qty' => 3,
                'bundleid'=>6,
            ],
            [
                'menuID'=>3,
                'qty' => 3,
                'bundleid'=>7,
            ],
            [
                'menuID'=>21,
                'qty' => 3,
                'bundleid'=>7,
            ],
            [
                'menuID'=>18,
                'qty' => 3,
                'bundleid'=>7,
            ],
            [
                'menuID'=>24,
                'qty' => 3,
                'bundleid'=>7,
            ],
            [
                'menuID'=>3,
                'qty' => 3,
                'bundleid'=>8,
            ],
            [
                'menuID'=>22,
                'qty' => 3,
                'bundleid'=>8,
            ],
            [
                'menuID'=>18,
                'qty' => 3,
                'bundleid'=>8, 
            ],
            [
                'menuID'=>11,
                'qty' => 4,
                'bundleid'=>8,
            ],


        ];
        DB::table('bundle_details')->insert($bundleMenu);
    }
}
