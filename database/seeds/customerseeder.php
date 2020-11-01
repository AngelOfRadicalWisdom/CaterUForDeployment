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
                'custid'=>1,
                'name'  => 'Maria',
                'phonenumber' => '09479842734'
            ],
            [
                'custid'=>2,
                'name'  => 'Jay',
                'phonenumber' => '09234424688'
            ],
            [
                'custid'=>3,
                'name'  => 'Rhea',
                'phonenumber' => '093688775435'
            ],
            [
                'custid'=>4,
                'name'  => 'John',
                'phonenumber' => '092271094671'
            ],
            [
                'custid'=>5,
                'name'  => 'Jade',
                'phonenumber' => '0944561074257'
            ],
            [
                'custid'=>6,
                'name'  => 'Rex',
                'phonenumber' => '094733578734'
            ],
            [
                'custid'=>7,
                'name'  => 'Maria',
                'phonenumber' => '091590643467'
            ],
        ];
        DB::table('customers')->insert($customers);
    }
}
