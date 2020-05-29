<?php

/** @var Factory $factory */

use App\Dish;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Dish::class, function (Faker $faker) {
    return [
        'number' => $faker->numberBetween(1, 80),
        'addition' => $faker->boolean(35) ? $faker->randomLetter : null,
        'price' => $faker->randomFloat(2, 0.5, 20),
        'description' => $faker->boolean(25) ? $faker->realText(350) : null
    ];
});
