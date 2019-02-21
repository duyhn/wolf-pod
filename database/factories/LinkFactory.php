<?php

$factory->define(App\Link::class, function (Faker\Generator $faker) {
    return [
        "link" => $faker->name,
    ];
});
