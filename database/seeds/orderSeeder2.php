<?php

use Illuminate\Database\Seeder;

class orderSeeder2 extends Seeder
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
                'order_id'    => 1,
                'orderQty'  =>  2,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  390.00
            ],
            [
                'order_id'    => 1,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 1,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 1,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'waiting',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 1,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 1,
                'orderQty'  =>  1,
                'menuID'    =>  13,
                'status'    =>  'served',
                'subtotal'  =>  479.00
            ],
            [
                'order_id'    => 1,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 1,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'waiting',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 1,
                'orderQty'  =>  2,
                'menuID'    =>  19,
                'status'    =>  'waiting',
                'subtotal'  =>  116.00
            ],
            [
                'order_id'    => 1,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  15,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  23,
                'status'    =>  'served',
                'subtotal'  =>  63.00
            ],
            [
                'order_id'    => 2,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  15,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  19,
                'status'    =>  'served',
                'subtotal'  =>  58.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 3,
                'orderQty'  =>  1,
                'menuID'    =>  23,
                'status'    =>  'served',
                'subtotal'  =>  63.00
            ],
            [
                'order_id'    => 4,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 4,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 4,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 4,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 4,
                'orderQty'  =>  1,
                'menuID'    =>  13,
                'status'    =>  'served',
                'subtotal'  =>  479.00
            ],
            [
                'order_id'    => 4,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 4,
                'orderQty'  =>  1,
                'menuID'    =>  15,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 4,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'  => 4,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 4,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 4,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 4,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  13,
                'status'    =>  'served',
                'subtotal'  =>  479.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 5,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  15,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  19,
                'status'    =>  'served',
                'subtotal'  =>  58.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  23,
                'status'    =>  'served',
                'subtotal'  =>  63.00
            ],
            [
                'order_id'    => 6,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 7,
                'orderQty'  =>  1,
                'menuID'    =>  23,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  15,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  19,
                'status'    =>  'served',
                'subtotal'  =>  58.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    => 20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 8,
                'orderQty'  =>  1,
                'menuID'    =>  23,
                'status'    =>  'served',
                'subtotal'  =>  63.00
            ],
            [
                'order_id'    => 9,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 9,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 9,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 9,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 9,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 9,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 9,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 9,
                'orderQty'  =>  1,
                'menuID'    =>  19,
                'status'    =>  'served',
                'subtotal'  =>  58.00
            ],
            [
                'order_id'    => 9,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  268.00
            ],
            [
                'order_id'    => 9,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 9,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],  
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 10,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  13,
                'status'    =>  'served',
                'subtotal'  =>  479.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 11,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    => 12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    => 13,
                'status'    =>  'served',
                'subtotal'  =>  479.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    => 16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    => 20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 12,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  => 47.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  => 265.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  => 193.00
            ],
            [
                'order_id'    => 13,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  => 73.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  13,
                'status'    =>  'served',
                'subtotal'  =>  479.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 14,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  19,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 15,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  13,
                'status'    =>  'served',
                'subtotal'  =>  479.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 16,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 17,
                'orderQty'  =>  1,
                'menuID'    =>  23,
                'status'    =>  'served',
                'subtotal'  =>  63.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],

            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  13,
                'status'    =>  'served',
                'subtotal'  =>  479.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 18,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  19,
                'status'    =>  'served',
                'subtotal'  =>  58.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],[
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 19,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 20,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  13,
                'status'    =>  'served',
                'subtotal'  =>  479.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 21,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 22,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 22,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 22,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 22,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 22,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 22,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 22,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 22,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 22,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 22,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 22,
                'orderQty'  =>  1,
                'menuID'    =>  23,
                'status'    =>  'served',
                'subtotal'  =>  63.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 23,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 24,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 24,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 24,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 24,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 24,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 24,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 24,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 24,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 24,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 24,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 24,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
             [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  13,
                'status'    =>  'served',
                'subtotal'  =>  479.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 25,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 26,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    => 12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 27,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  16,
                'status'    =>  'served',
                'subtotal'  =>  37.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  19,
                'status'    =>  'served',
                'subtotal'  =>  58.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 28,
                'orderQty'  =>  1,
                'menuID'    =>  23,
                'status'    =>  'served',
                'subtotal'  =>  63.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  9,
                'status'    =>  'served',
                'subtotal'  =>  297.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  13,
                'status'    =>  'served',
                'subtotal'  =>  479.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 29,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  2,
                'status'    =>  'served',
                'subtotal'  =>  215.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  3,
                'status'    =>  'served',
                'subtotal'  =>  195.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  5,
                'status'    =>  'served',
                'subtotal'  =>  180.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  8,
                'status'    =>  'served',
                'subtotal'  =>  359.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  10,
                'status'    =>  'served',
                'subtotal'  =>  323.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  11,
                'status'    =>  'served',
                'subtotal'  =>  338.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  12,
                'status'    =>  'served',
                'subtotal'  =>  474.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  14,
                'status'    =>  'served',
                'subtotal'  =>  755.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  17,
                'status'    =>  'served',
                'subtotal'  =>  219.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  18,
                'status'    =>  'served',
                'subtotal'  =>  47.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  20,
                'status'    =>  'served',
                'subtotal'  =>  265.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  21,
                'status'    =>  'served',
                'subtotal'  =>  193.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  22,
                'status'    =>  'served',
                'subtotal'  =>  73.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  23,
                'status'    =>  'served',
                'subtotal'  =>  63.00
            ],
            [
                'order_id'    => 30,
                'orderQty'  =>  1,
                'menuID'    =>  24,
                'status'    =>  'served',
                'subtotal'  =>  99.00
            ],
  ];
        DB::table('order_details')->insert($orders);
    }
}
