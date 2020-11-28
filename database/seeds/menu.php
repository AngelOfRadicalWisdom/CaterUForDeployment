<?php

use Illuminate\Database\Seeder;

class menu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
           // [
                // 'menuID' => 3001,
                // 'name'  => 'Spaghetti',
                // 'details'=> 'This is not jollibee spaghetti',
                // 'price' => 100.00,
                // 'servingsize' => 3,
                // 'image'=> null,
            //     // 'subcatid'=> 2003
            //     'name'  => 'Birds Nest',
            //     'details'=> 'Chicken and quail eggs',
            //     'price' => 120.00,
            //     'servingsize' => 2,
            //     'image'=> null,
            //     'subcatid'=> 2
            // ],
            
            [
                'menuID'=>2,
                'name'  => '3 pcs. Chicken Barbecue',
                'details'=> '3 pcs. of Aristocrat\'s, most popular dish, Chicken Barbecue w/ Java Rice and Java Sauce * A la carte (no rice) option also available ** P 10 for extra Java Sauce.',
                'price' => 215.00,
                'servingsize' => 1,
                'status'=>'AVAILABLE',
                'image'=> '3pcs_Chicken_Barbecue3.png',
                'subcatid'=> 1
            ],
            [
                'menuID'=>3,
                'name'  => 'Boneless Chicken Barbecue',
                'details'=> 'Boneless (BLESS) Chicken Barbecue w/ Java Rice and Java Sauce * A la carte (no rice) option also available **
                P 10 for extra Java Sauce.',
                'price' => 195.00,
                'servingsize' => 3,
                'status'=>'AVAILABLE',
                'image'=> 'Boneless_Chicken_Barbecue3.png',
                'subcatid'=> 1
            ],
            [
                'menuID'=>5,
                'name'  => 'Pork Barbecue',
                'details'=> '2 sticks of Aristocrat\'s flavorful Pork Barbecue w/ Java RIce and Java Sauce * A la carte (no rice) option also available ** P 10 for extra Java Sauce.',
                'price' => 180,
                'servingsize' => 1,
                'status'=>'AVAILABLE',
                'image'=> 'Pork_Barbecue3.png',
                'subcatid'=> 2
            ],
            [
                'menuID'=>8,
                'name'  => 'Pork Spareribs Barbecue (whole/half)',
                'details'=> 'Grilled lean and tender choice cut pork ribs',
                'price' => 359,
                'servingsize' => 2,
                'status'=>'AVAILABLE',
                'image'=> 'Pork_Spareribs3.png',
                'subcatid'=> 2
            ],
            [
                'menuID'=>9,
                'name'  => 'Calamares',
                'details'=> 'Batter-coated and deep-fried squid served with tartar sauce',
                'price' =>297,
                'servingsize' =>2,
                'status'=>'AVAILABLE',
                'image'=>'Calamares3.png',
                'subcatid'=> 3
            ],
            [
                'menuID'=>10,
                'name'  => 'Sizzling Gambas',
                'details'=> 'Shrimp in a special blend of spices, sprinkled with roasted garlic.',
                'price' => 323,
                'servingsize' => 2,
                'status'=>'AVAILABLE',
                'image'=> 'Sizzling_Gambas3.png',
                'subcatid'=> 3
            ],
            [
                'menuID'=>11,
                'name'  => 'Camaron Rebosado',
                'details'=> 'Deep-fried battered shrimp served with sweet and sour sauce.',
                'price' => 338,
                'servingsize' => 2,
                'status'=>'AVAILABLE',
                'image'=> 'Camaron_Rebosado3.png',
                'subcatid'=> 3
            ],
            [
                'menuID'=>12,
                'name'  => 'Kare-Kare',
                'details'=> '3 pcs. of Aristocrat\'s, most popular dish, Chicken Barbecue w/ Java Rice and Java Sauce * A la carte (no rice) option also available ** P 10 for extra Java Sauce.',
                'price' => 474.00,
                'servingsize' => 4,
                'status'=>'AVAILABLE',
                'image'=> 'Kare-Kare3.png',
                'subcatid'=> 4
            ],
            [
                'menuID'=>13,
                'name'  => 'Bulalo',
                'details'=> 'Slowly cooked, rich, beef soup with bone marrow and vegetables.',
                'price' => 479,
                'servingsize' => 4,
                'status'=>'AVAILABLE',
                'image'=> 'Bulalo3.png',
                'subcatid'=> 4
            ],
            [
                'menuID'=>14,
                'name'  => 'Crispy Pata',
                'details'=> 'Deep fried leg of pork, with homemade atcahara',
                'price' => 755,
                'servingsize' => 4,
                'status'=>'AVAILABLE',
                'image'=> 'Crispy_Pata3.jpg',
                'subcatid'=> 5
            ],
            [
                'menuID'=>15,
                'name'  => 'Sinigang na Baboy',
                'details'=> 'Pork spareribs with native vegetables in sour tamarind soup.',
                'price' => 338,
                'servingsize' => 4,
                'status'=>'AVAILABLE',
                'image'=> 'SinigangnaBaboy3.jpg',
                'subcatid'=> 5
            ],
            [
                'menuID'=>16,
                'name'  => 'Plain Rice',
                'details'=> '',
                'price' =>37,
                'servingsize' =>3,
                'status'=>'AVAILABLE',
                'image'=> 'Plain_Rice3.png',
                'subcatid'=> 6
            ],
            [
                'menuID'=>17,
                'name'  => 'Shanghai Rice',
                'details'=> 'Fried rice with pork, shrimp, ham, sausage, and egg.',
                'price' => 219,
                'servingsize' => 3,
                'status'=>'AVAILABLE',
                'image'=> 'Shanghai_Rice3.png',
                'subcatid'=> 7
            ],
            [
                'menuID'=>18,
                'name'  => 'Aristocrat Java Rice',
                'details'=> 'Signature fried rice of the restaurant pairs perfectly with any of the barbecue dishes.',
                'price' => 47,
                'servingsize' => 1,
                'status'=>'AVAILABLE',
                'image'=> 'Java_Rice3.png',
                'subcatid'=> 7
            ],
            [
                'menuID'=>19,
                'name'  => 'Ice Cream',
                'details'=> 'Scoop of Ube, Vanilla, Strawberry, or Chocolate.',
                'price' => 58.00,
                'servingsize' => 1,
                'status'=>'AVAILABLE',
                'image'=> 'ice-cream.jpg',
                'subcatid'=> 8
            ],
            [
                'menuID'=>20,
                'name'  => 'Banana Split',
                'details'=> 'Three (3) scoops opf ice cream, with chocolate, caramel, and strawberry syrup whipped cream, and nuts.',
                'price' => 265.00,
                'servingsize' => 3,
                'status'=>'AVAILABLE',
                'image'=> 'banana-split.png',
                'subcatid'=> 8
            ],
            [
                'menuID'=>21,
                'name'  => 'Fresh Fruit Salad',
                'details'=> 'Also Available: Fruit per slice-Mango,Papaya, and Bananas.',
                'price' => 193,
                'servingsize' => 1,
                'status'=>'AVAILABLE',
                'image'=> 'Fruit_Salad3.png',
                'subcatid'=> 9
            ],
            [
                'menuID'=>22,
                'name'  => 'House Blend Ice Tea',
                'details'=> '',
                'price' => 73,
                'servingsize' => 1,
                'status'=>'AVAILABLE',
                'image'=> 'colddrinks2.png',
                'subcatid'=> 10
            ],
            [
                'menuID'=>23,
                'name'  => 'Iced Coffee',
                'details'=> '',
                'price' =>63,
                'servingsize' =>1,
                'status'=>'OCCUPIED',
                'image'=> 'colddrinks2.png',
                'subcatid'=> 10
            ],
            [
                'menuID'=>24,
                'name'  => 'Beer',
                'details'=> '',
                'price' => 99,
                'servingsize' => 1,
                'status'=>'AVAILABLE',
                'image'=> 'colddrinks2.png',
                'subcatid'=> 11
            ],
           
           
        ];
        DB::table('menus')->insert($menus);
    }
}
