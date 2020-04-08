<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Media;
use App\MediaType;
use Faker\Generator as Faker;

$factory->define(Media::class, function (Faker $faker, $params) {
    return [
        'link' => $faker->imageUrl(),
        'media_type_id' => MediaType::where('name', '=', 'http')->firstOrFail()['id'],
        'good_id'  => $params['good_id'],
    ];
});
