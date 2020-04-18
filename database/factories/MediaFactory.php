<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Media;
use App\MediaType;
use Faker\Generator as Faker;

$factory->define(Media::class, function (Faker $faker, $params) {
    return [
        'link' => 'https://www.colorbook.io/imagecreator.php?width='.$faker->randomNumber(3)
            .'&height='.$faker->randomNumber(3),
        'media_type_id' => MediaType::where('name', '=', 'http')->firstOrFail()['id'],
        'good_id'  => $params['good_id'],
    ];
});
