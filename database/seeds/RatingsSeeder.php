<?php

use Illuminate\Database\Seeder;

class RatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratings = [
        
            [
                'id'=>1,
                'star'=> '5'
            ],
            [
                'id'=>2,
                'star'=> '5'
            ],
            [
                'id'=>3,
                'star'=> '5',
            ],
            [
                'id'=>4,
                'star'=> '5',
            ],
            [
                'id'=>5,
                'star'=> '5',
            ],
            [
                'id'=>6,
                'star'=> '4',
             
            ],
            [
                'id'=>7,
                'star'=> '4'
            ],
            [
                'id'=>8,
                'star'=> '4'
            ],
            [
                'id'=>9,
                'star'=> '4'
            ],
            [
                'id'=>10,
                'star'=> '3'
            ],
            [
                'id'=>11,
                'star'=> '3'
            ],
            [
                'id'=>12,
                'star'=> '3'
            ],
            [
                'id'=>13,
                'star'=> '2'
            ],
            [
                'id'=>14,
                'star'=> '2'
            ],
            [
                'id'=>15,
                'star'=> '1'
            ],
            
            
            

        ];
        DB::table('ratings')->insert($ratings);
    }

    }