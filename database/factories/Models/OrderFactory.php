<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'payment_method' => $faker->word,
        'subtotal' => $faker->randomFloat(0, 0, 9999999999.),
        'shipping_fee' => $faker->randomFloat(0, 0, 9999999999.),
        'discount' => $faker->randomFloat(0, 0, 9999999999.),
    ];
});
