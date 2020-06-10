<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        if (env('APP_DEBUG')) {
            $this->call([
                UserSeeder::class,
                DishesSeeder::class,
                OffersSeeder::class,
                OrdersSeeder::class
            ]);
        } else {
            $this->call([
                MenuSeeder::class,
                SaleSeeder::class
            ]);
        }

        Model::reguard();
    }
}
