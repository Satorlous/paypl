<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->words(rand(1,3), true);
    return [
        'name' => $name,
        'tax' => $faker->randomFloat(2, 0, 1),
        'slug' => Str::slug($name)
    ];
});
