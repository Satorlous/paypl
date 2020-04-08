<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->words(rand(1,3), true),
        'tax' => $faker->randomFloat(2, 0, 1),
    ];
});
