<?php

use App\Offer;
use App\Dish;
use Illuminate\Database\Seeder;

class OffersSeeder extends Seeder
{
    public function run()
    {
        $dishes = Dish::all();

        factory(Offer::class, 20)->create()->each(function (Offer $offer) use ($dishes) {
            $randomDishes = $dishes->random(rand(1, 4));

            foreach ($randomDishes as $randomDish) {
                $offer->dishes()->save($randomDish, [
                    'price' => $randomDish->price * 0.75,
                    'tax' => 9
                ]);
            }
        });
    }
}
