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
                'username'  =>  'amyra',
                'password'  =>  bcrypt('123456'),
                'position'  => 'admin'
            ],
            [
                'empfirstname' =>  'Jose',
                'emplastname'  =>  'Dela Cruz',
                'username'  =>  'cjose',
                'password'  =>  bcrypt('123456'),
                'position'  => 'cashier'
            ],
            [
                'empfirstname' =>  'Cardo',
                'emplastname'  =>  'Dalisay',
                'username'  =>  'wcardo',
                'password'  =>  bcrypt('123456'),
                'position'  => 'waiter'
            ],
            [
                'empfirstname' =>  'Elaine',
                'emplastname'  =>  'Perez',
                'username'  =>  'kelaine',
                'password'  =>  bcrypt('123456'),
                'position'  => 'kitchenStaff'
            ],
            [
                'empfirstname' =>  'Richard',
                'emplastname'  =>  'Gomez',
                'username'  =>  'rrichard',
                'password'  =>  bcrypt('123456'),
                'position'  => 'receptionist'
            ],
            [
                'empfirstname' =>  'Mi Soo',
                'emplastname'  =>  'Kim',
                'username'  =>  'akim',
                'password'  =>  bcrypt('123456'),
                'position'  => 'admin'
            ],
            [
                'empfirstname' =>  'Angelo',
                'emplastname'  =>  'De la Cruz',
                'username'  =>  'dangelo',
                'password'  =>  bcrypt('123456'),
                'position'  => 'dispatcher'
            ],
            [
                'empfirstname' =>  'Tanya',
                'emplastname'  =>  'Guerrero',
                'username'  =>  'mtanya',
                'password'  =>  bcrypt('123456'),
                'position'  => 'manage'
            ],


        ];
        DB::table('employees')->insert($employees);
    }
}
