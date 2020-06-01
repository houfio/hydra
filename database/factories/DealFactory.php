<?php

/** @var Factory $factory */

use App\Deal;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Deal::class, function (Faker $faker) {
    return [
        'name' => $faker->realText('70'),
        'valid_until' => $faker->boolean(75) ? $faker->dateTimeBetween('now', '+1 month') : null
    ];
});
