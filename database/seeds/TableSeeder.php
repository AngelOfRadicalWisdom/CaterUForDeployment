<?php

use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = [
            [
                'tableno'=>1,
                'capacity'=> 4,
                'status'    => 'Available'
            ],
            [
                'tableno'=>2,
                'capacity'=> 6,
                'status'    => 'Available'
            ],
            [
                'tableno'=>3,
                'capacity'=> 2,
                'status'    => 'Available'
            ],
            [
                'tableno'=>4,
                'capacity'=> 4,
                'status'    => 'Available'
            ],
            [
                'tableno'=>5,
                'capacity'=> 6,
                'status'    => 'Available'
            ],
            [
               'tableno'=>6,
                'capacity'=> 2,
                'status'    => 'Available'
            ]
        
        ];
        DB::table('tables')->insert($tables);
    }
}
