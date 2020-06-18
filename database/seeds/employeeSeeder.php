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
                'empfirstname' =>  'Myra',
                'emplastname'  =>  'Pelostratos',
                'username'  =>  'adminmyra',
                'password'  =>  bcrypt('123456'),
                'position'  => 'admin'
            ],
            [
                'empfirstname' =>  'Jose',
                'emplastname'  =>  'Dela Cruz',
                'username'  =>  'cashierjose',
                'password'  =>  bcrypt('123456'),
                'position'  => 'cashier'
            ],
            [
                'empfirstname' =>  'Cardo',
                'emplastname'  =>  'Dalisay',
                'username'  =>  'waitercardo',
                'password'  =>  bcrypt('123456'),
                'position'  => 'waiter'
            ],
            [
                'empfirstname' =>  'Elaine',
                'emplastname'  =>  'Perez',
                'username'  =>  'waiterelaine',
                'password'  =>  bcrypt('123456'),
                'position'  => 'waiter'
            ],
            [
                'empfirstname' =>  'Richard',
                'emplastname'  =>  'Gomez',
                'username'  =>  'receptionistrichard',
                'password'  =>  bcrypt('123456'),
                'position'  => 'receptionist'
            ],
            [
                'empfirstname' =>  'Mi Soo',
                'emplastname'  =>  'Kim',
                'username'  =>  'kim101',
                'password'  =>  bcrypt('1234'),
                'position'  => 'admin'
            ],

        ];
        DB::table('employees')->insert($employees);
    }
}
