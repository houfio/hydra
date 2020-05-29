<?php

/** @var Factory $factory */

use App\DishType;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(DishType::class, function (Faker $faker) {
    $types = [
        'Rijsten',
        'Vegetarisch',
        'Zonder vlees',
        'Voor kinderen',
        'Loempia\'s',
        'Halal'
    ];

    return [
        'name' => $types[array_rand($types)]
    ];
});
