<?php

use Illuminate\Database\Seeder;

class customerseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            [
                'name'  => 'Maria',
                'phonenumber' => '09479842734'
            ],
            [
                'name'  => 'Jay',
                'phonenumber' => '09234424688'
            ],
            [
                'name'  => 'Rhea',
                'phonenumber' => '093688775435'
            ],
            [
                'name'  => 'John',
                'phonenumber' => '092271094671'
            ],
            [
                'name'  => 'Jade',
                'phonenumber' => '0944561074257'
            ],
            [
                'name'  => 'Rex',
                'phonenumber' => '094733578734'
            ],
            [
                'name'  => 'Maria',
                'phonenumber' => '091590643467'
            ],
        ];
        DB::table('customers')->insert($customers);
    }
}
