<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Good;
use App\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Good::class, function (Faker $faker, $params) {
    $name = $faker->words(3, true);
    return [
        'name'         => $name,
        'price'        => $faker->randomFloat(2, 0, 100000),
        'quantity'     => $faker->randomDigit,
        'discount'     => $faker->randomFloat(2, 0, 1),
        'user_id'      => $params['user_id'],
        'status_id'    => 1,
        'description'  => $faker->realText(),
        'created_at'   => $faker->dateTime(),
        'updated_at'   => now(),
        'category_id'  => Category::all()->where('parent_id','!=','null')->random()['id'],
        'slug'         => Str::slug($name),
    ];
});
