<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Eloquent::unguard();

        $this->call(CategorySeeder::class);
        $this->call(SubCategorySeeder::class);
        $this->call(MenuSeeder::class);
        // $this->call(orderSeeder::class);
        $this->call(TableSeeder::class);
    }
}
