<?php

use Illuminate\Database\Seeder;

class orderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = [
         [
            'order_id'=>1,
            'custid'=>2,
            'empid'=>1000,
            'tableno'=>2 ,
            'total'=>2509,
            'cashTender'=>2510,
            'change'=>1,
            'status'=>'paid',
            'date_ordered'=>'2020-11-15 15:04:53'
         ],
         [
             'order_id'=>2,
             'custid'=>1,
             'empid'=>1002,
             'tableno'=>1 ,
             'total'=>3748,
             'cashTender'=>4000,
             'change'=>252,
             'status'=>'paid',
             'date_ordered'=>'2020-11-16 15:04:53'
          ],
          [
             'order_id'=>3,
             'custid'=>1,
             'empid'=>1003,
             'tableno'=>4,
             'total'=>2867,
             'cashTender'=>3000,
             'change'=>133,
             'status'=>'paid',
             'date_ordered'=>'2020-11-17 15:04:53'
          ],
          [
             'order_id'=>4,
             'custid'=>1,
             'empid'=>1001,
             'tableno'=>5,
             'total'=>3352,
             'cashTender'=>3360,
             'change'=>8,
             'status'=>'paid',
             'date_ordered'=>'2020-11-18 15:04:53'
          ],
          [
             'order_id'=>5,
             'custid'=>2,
             'empid'=>1003,
             'tableno'=>6,
             'total'=>3859,
             'cashTender'=>3900,
             'change'=>41,
             'status'=>'paid',
             'date_ordered'=>'2020-11-19 15:04:53'
          ],
             [
            'order_id'=>6,
            'custid'=>3,
            'empid'=>1002,
            'tableno'=>6 ,
            'total'=>3130,
            'cashTender'=>3200,
            'change'=>70,
            'status'=>'paid',
            'date_ordered'=>'2020-11-20 15:04:53'
         ],
         [
             'order_id'=>7,
             'custid'=>1,
             'empid'=>1006,
             'tableno'=>5 ,
             'total'=>3550,
             'cashTender'=>3600,
             'change'=>50,
             'status'=>'paid',
             'date_ordered'=>'2020-11-21 15:04:53'
          ],
          [
             'order_id'=>8,
             'custid'=>2,
             'empid'=>1005,
             'tableno'=>1,
             'total'=>2659,
             'cashTender'=>3000,
             'change'=>391,
             'status'=>'paid',
             'date_ordered'=>'2020-11-22 15:04:53'
          ],
          [
             'order_id'=>9,
             'custid'=>3,
             'empid'=>1002,
             'tableno'=>3,
             'total'=>2516,
             'cashTender'=>2520,
             'change'=>4,
             'status'=>'paid',
             'date_ordered'=>'2020-11-23 15:04:53'
          ],
          [
             'order_id'=>10,
             'custid'=>1,
             'empid'=>1003,
             'tableno'=>4,
             'total'=>3772,
             'cashTender'=>4000,
             'change'=>228,
             'status'=>'paid',
             'date_ordered'=>'2020-11-24 15:04:53'

          ],
          [
            'order_id'=>11,
            'custid'=>2,
            'empid'=>1001,
            'tableno'=>1,
            'total'=>3438,
            'cashTender'=>3500,
            'change'=>62,
            'status'=>'paid',
            'date_ordered'=>'2020-11-25 15:04:53'
         ],
         [
             'order_id'=>12,
             'custid'=>3,
             'empid'=>1004,
             'tableno'=>5,
             'total'=>3236,
             'cashTender'=>3240,
             'change'=>4,  
             'status'=>'paid',
             'date_ordered'=>'2020-11-26 15:04:53'
          ],
          [
             'order_id'=>13,
             'custid'=>1,
             'empid'=>1006,
             'tableno'=>6,
             'total'=>3970,
             'cashTender'=>4000,
             'change'=>30,
             'status'=>'paid',
             'date_ordered'=>'2020-11-27 15:04:53'
          ],
          [
             'order_id'=>14,
             'custid'=>2,
             'empid'=>1001,
             'tableno'=>3,
             'total'=>3455,
             'cashTender'=>3460,
             'change'=>5,
             'status'=>'paid',
             'date_ordered'=>'2020-11-28 15:04:53'
          ],
          [
             'order_id'=>15,
             'custid'=>3,
             'empid'=>1003,
             'tableno'=>4,
             'total'=>3688,
             'cashTender'=>3700,
             'change'=>22,
             'status'=>'paid',
             'date_ordered'=>'2020-11-29 15:04:53'
          ],
            [
            'order_id'=>16,
            'custid'=>1,
            'empid'=>1002,
            'tableno'=>6,
            'total'=>4163,
            'cashTender'=>4200,
            'change'=>37,
            'status'=>'paid',
            'date_ordered'=>'2020-11-30 15:04:53'
         ],
         [
             'order_id'=>17,
             'custid'=>2,
             'empid'=>1003,
             'tableno'=>1,
             'total'=>3481,
             'cashTender'=>3500,
             'change'=>19,
             'status'=>'paid',
             'date_ordered'=>'2020-12-01 15:04:53'
          ],
          [
             'order_id'=>18,
             'custid'=>3,
             'empid'=>1005,
             'tableno'=>2,
             'total'=>3751,
             'cashTender'=>3800,
             'change'=>49,
             'status'=>'paid',
             'date_ordered'=>'2020-12-02 15:04:53'
          ],
          [
             'order_id'=>19,
             'custid'=>1,
             'empid'=>1002,
             'tableno'=>3,
             'total'=>3309,
             'cashTender'=>3310,
             'change'=>1,
             'status'=>'paid',
             'date_ordered'=>'2020-12-03 15:04:53'
          ],
          [
             'order_id'=>20,
             'custid'=>2,
             'empid'=>1003,
             'tableno'=>4,
             'total'=>3455,
             'cashTender'=>3500,
             'change'=>45,
             'status'=>'paid',
             'date_ordered'=>'2020-12-04 15:04:53'
          ],
          [
            'order_id'=>21,
            'custid'=>1,
            'empid'=>1001,
            'tableno'=>2 ,
            'total'=>3558,
            'cashTender'=>3660,
            'change'=>2,
            'status'=>'paid',
            'date_ordered'=>'2020-12-05 15:04:53'
         ],
         [
             'order_id'=>22,
             'custid'=>2,
             'empid'=>1002,
             'tableno'=>1 ,
             'total'=>2991,
             'cashTender'=>3000,
             'change'=>9,
             'status'=>'paid',
             'date_ordered'=>'2020-12-06 15:04:53'
          ],
          [
             'order_id'=>23,
             'custid'=>3,
             'empid'=>1003,
             'tableno'=>4,
             'total'=>2861,
             'cashTender'=>2870,
             'change'=>9,
             'status'=>'paid',
             'date_ordered'=>'2020-12-07 15:04:53'
          ],
          [
             'order_id'=>24,
             'custid'=>1,
             'empid'=>1001,
             'tableno'=>5,
             'total'=>2845,
             'cashTender'=>2850,
             'change'=>5,
             'status'=>'paid',
             'date_ordered'=>'2020-12-08 15:04:53'
          ],
          [
             'order_id'=>25,
             'custid'=>2,
             'empid'=>1003,
             'tableno'=>6,
             'total'=>3678,
             'cashTender'=>3680,
             'change'=>2,
             'status'=>'paid',
             'date_ordered'=>'2020-12-09 15:04:53'
          ],
             [
            'order_id'=>26,
            'custid'=>3,
            'empid'=>1002,
            'tableno'=>6 ,
            'total'=>3402,
            'cashTender'=>3420,
            'change'=>18,
            'status'=>'paid',
            'date_ordered'=>'2020-12-10 15:04:53'
         ],
         [
             'order_id'=>27,
             'custid'=>1,
             'empid'=>1006,
             'tableno'=>5 ,
             'total'=>2580,
             'cashTender'=>2600,
             'change'=>20,
             'status'=>'paid',
             'date_ordered'=>'2020-12-11 15:04:53'
          ],
          [
             'order_id'=>28,
             'custid'=>2,
             'empid'=>1005,
             'tableno'=>1,
             'total'=>2427,
             'cashTender'=>2430,
             'change'=>3,
             'status'=>'paid',
             'date_ordered'=>'2020-12-12 15:04:53'
          ],
          [
             'order_id'=>29,
             'custid'=>3,
             'empid'=>1002,
             'tableno'=>3,
             'total'=>3418,
             'cashTender'=>3420,
             'change'=>2,
             'status'=>'paid',
             'date_ordered'=>'2020-12-13 15:04:53'
          ],
          [
             'order_id'=>30,
             'custid'=>1,
             'empid'=>1003,
             'tableno'=>4,
             'total'=>3798,
             'cashTender'=>3800,
             'change'=>2,
             'status'=>'paid',
             'date_ordered'=>'2020-12-14 15:04:53'
          ],
        ];
        DB::table('orders')->insert($orders);
    }
}

