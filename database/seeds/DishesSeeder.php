<?php

use App\Dish;
use App\DishType;
use Illuminate\Database\Seeder;

class DishesSeeder extends Seeder
{
    private const DISH_TYPES = [
        'Rijsten',
        'Vegetarisch',
        'Zonder vlees',
        'Voor kinderen',
        'Loempia\'s',
        'Halal'
    ];

    public function run()
    {
        $dishTypes = [];

        foreach (self::DISH_TYPES as $name) {
            $type = new DishType();

            $type->name = $name;

            $type->save();
            $dishTypes[] = $type;
        }

        factory(Dish::class, 80)->make()->each(function (Dish $dish) use ($dishTypes) {
            $dish->type()->associate($dishTypes[array_rand($dishTypes)])->save();
        });
    }
}
