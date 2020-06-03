<?php

use App\Dish;
use App\Offer;
use App\Order;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        $dishes = Dish::all();
        $offers = Offer::all();

        factory(Order::class, 20)->create()->each(function (Order $order) use ($dishes, $offers) {
            $randomDishes = $dishes->random(rand(3, 8));
            $randomOffers = $offers->random(rand(0, 2));

            foreach ($randomDishes as $randomDish) {
                $order->dishes()->save($randomDish, [
                    'price' => $randomDish->price,
                    'quantity' => rand(1, 3),
                    'tax' => 9
                ]);
            }

            foreach ($randomOffers as $randomOffer) {
                $order->offers()->save($randomOffer, [
                   'price' => $randomOffer->price,
                   'quantity' => rand(1, 2),
                   'tax' => 9
                ]);
            }
        });
    }
}
