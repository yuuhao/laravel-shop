<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductSku::class, function (Faker $faker) {
    return [
        'title'         => $faker->word,
        'description'   => $faker->sentence,
        'stock'         => $faker->randomNumber(3),
        'price'         => $faker->randomNumber(4)
    ];
});
