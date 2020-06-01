<?php

use App\Deal;
use App\Dish;
use Illuminate\Database\Seeder;

class DealsSeeder extends Seeder
{
    public function run()
    {
        $dishes = Dish::all();

        factory(Deal::class, 20)->create()->each(function (Deal $deal) use ($dishes) {
            $randomDishes = $dishes->random(rand(1, 4));

            foreach ($randomDishes as $randomDish) {
                $deal->dishes()->save($randomDish, [
                    'price' => $randomDish->price * 0.75,
                    'tax' => 9
                ]);
            }
        });
    }
}
