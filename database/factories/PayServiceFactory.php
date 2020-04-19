<?php

/** @var Factory $factory */

use App\PayService;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(PayService::class, function (Faker $faker) {
    return [
        'name' => $faker->domainName,
        'link' => $faker->url,
        'icon' => 'https://www.colorbook.io/imagecreator.php?width=100&height=100',
    ];
});
