<?php

/** @var Factory $factory */

use App\Offer;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Offer::class, function (Faker $faker) {
    return [
        'name' => $faker->realText('70'),
        'valid_until' => $faker->boolean(75) ? $faker->dateTimeBetween('now', '+1 month') : null,
        'price' => $faker->randomFloat(2, 7.5, 50),
        'tax' => 9
    ];
});
