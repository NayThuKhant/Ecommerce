<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Variant;
use Faker\Generator as Faker;

$factory->define(Variant::class, function (Faker $faker) {
    return [
        'product_id' => factory(\App\Models\Product::class),
        'color_family' => $faker->word,
        'photos' => $faker->text,
        'SKU' => $faker->word,
    ];
});
