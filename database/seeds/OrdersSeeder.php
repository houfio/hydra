<?php

use App\Dish;
use App\Order;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        $dishes = Dish::all();

        factory(Order::class, 20)->create()->each(function (Order $order) use ($dishes) {
            $randomDishes = $dishes->random(rand(3, 8));

            foreach ($randomDishes as $randomDish) {
                $order->dishes()->save($randomDish, [
                    'price' => $randomDish->price,
                    'quantity' => rand(1, 3),
                    'tax' => 9
                ]);
            }
        });
    }
}
