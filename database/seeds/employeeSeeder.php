<?php

use Illuminate\Database\Seeder;

class employeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees= [
            [
                'empid'=>1,
                'empfirstname' =>  'Myra',
                'emplastname'  =>  'Pelostratos',
                'username'  =>  'amyra',
                'password'  =>  bcrypt('123456'),
                'position'  => 'admin'
            ],
            [
                'empid'=>2,
                'empfirstname' =>  'Jose',
                'emplastname'  =>  'Dela Cruz',
                'username'  =>  'cjose',
                'password'  =>  bcrypt('123456'),
                'position'  => 'cashier'
            ],
            [
                'empid'=>3,
                'empfirstname' =>  'Cardo',
                'emplastname'  =>  'Dalisay',
                'username'  =>  'wcardo',
                'password'  =>  bcrypt('123456'),
                'position'  => 'waiter'
            ],
            [
                'empid'=>4,
                'empfirstname' =>  'Elaine',
                'emplastname'  =>  'Perez',
                'username'  =>  'kelaine',
                'password'  =>  bcrypt('123456'),
                'position'  => 'kitchenStaff'
            ],
            [
                'empid'=>5,
                'empfirstname' =>  'Richard',
                'emplastname'  =>  'Gomez',
                'username'  =>  'rrichard',
                'password'  =>  bcrypt('123456'),
                'position'  => 'receptionist'
            ],
            [
                'empid'=>6,
                'empfirstname' =>  'Mi Soo',
                'emplastname'  =>  'Kim',
                'username'  =>  'akim',
                'password'  =>  bcrypt('123456'),
                'position'  => 'admin'
            ],
            [
                'empid'=>7,
                'empfirstname' =>  'Angelo',
                'emplastname'  =>  'De la Cruz',
                'username'  =>  'dangelo',
                'password'  =>  bcrypt('123456'),
                'position'  => 'dispatcher'
            ],
            [
                'empid'=>8,
                'empfirstname' =>  'Tanya',
                'emplastname'  =>  'Guerrero',
                'username'  =>  'mtanya',
                'password'  =>  bcrypt('123456'),
                'position'  => 'manager'
            ],


        ];
        DB::table('employees')->insert($employees);
    }
}
