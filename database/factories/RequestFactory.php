<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Request;
use Faker\Generator as Faker;

$factory->define(Request::class, function (Faker $faker, $params) {
    $n = $faker->randomNumber(5).$faker->randomNumber(5);
    return [
        'status_id' => rand(100, 102),
        'user_id' => $params['user_id'],
        'content' => "{\"fio\":\"$faker->lastName $faker->name\",\"birthdate\":\"$faker->date\",\"doc_number\":\"$n\",\"doc_own\":\"$faker->sentence\",\"doc_date\":\"$faker->date\",\"address\":\"$faker->city, $faker->streetAddress\"}",
        'created_at'   => $faker->dateTime(),
        'updated_at'   => now(),
    ];
});
