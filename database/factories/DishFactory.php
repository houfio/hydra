<?php

/** @var Factory $factory */

use App\Dish;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Dish::class, function (Faker $faker) {
    $number = $faker->numberBetween(1, 80);

    if ($faker->boolean(35)) {
        $number .= $faker->randomLetter;
    }

    return [
        'number' => $number,
        'price' => $faker->randomFloat(2, 0.5, 20),
        'description' => $faker->boolean(25) ? $faker->realText(350) : null
    ];
});
