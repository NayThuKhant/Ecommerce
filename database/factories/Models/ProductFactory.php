<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'highlight' => $faker->text,
        'description' => $faker->text,
        'included' => $faker->text,
    ];
});
