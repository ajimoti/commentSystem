<?php

use Faker\Generator as Faker;

$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'user_name' => $faker->name,
        'body' => $faker->sentence
    ];
});
