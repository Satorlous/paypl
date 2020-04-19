<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ContactService;
use Faker\Generator as Faker;

$factory->define(ContactService::class, function (Faker $faker) {
    return [
        'name' => $faker->domainName,
        'link' => $faker->url,
        'icon' => 'https://www.colorbook.io/imagecreator.php?width=100&height=100',
    ];
});
