<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Request;
use Faker\Generator as Faker;

$factory->define(Request::class, function (Faker $faker, $params) {
    return [
        'status_id' => rand(100, 104),
        'user_id' => $params['user_id'],
        'content' => $faker->sentences(rand(2, 5), true),
        'created_at'   => $faker->dateTime(),
        'updated_at'   => now(),
    ];
});
