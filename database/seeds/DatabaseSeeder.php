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

        $this->call(category::class);
        $this->call(subcategory::class);
        $this->call(menu::class);
        $this->call(orderSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
