<?php

$factory->define(App\ExtractManager::class, function (Faker\Generator $faker) {
    return [
        "title" => $faker->name,
        "description" => $faker->name,
    ];
});
