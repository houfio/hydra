<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call([
            UserSeeder::class,
            DishesSeeder::class,
            OffersSeeder::class,
            OrdersSeeder::class
        ]);

        Model::reguard();
    }
}
