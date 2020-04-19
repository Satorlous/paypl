<?php

/** @var Factory $factory */

use App\Message;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Message::class, function (Faker $faker, $params) {
    $datetime = $faker->dateTime;
    return [
        'user_id' => $params['user_id'],
        'chat_id' => $params['chat_id'],
        'content' => $faker->sentence,
        'created_at'   => $datetime,
        'updated_at'   => $datetime,
    ];
});
