<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;
use \Illuminate\Support\Str;

$factory->define(Order::class, function (Faker $faker, $params) {
    return [
        'user_id'     => $params['user_id'],
        'status_id'   => $params['status_id'],
        'token'       => Str::random(10),
        'created_at'  => $faker->dateTime(),
        'updated_at'   => now(),
    ];
});
