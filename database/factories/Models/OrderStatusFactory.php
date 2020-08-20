<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderStatus;
use Faker\Generator as Faker;

$factory->define(OrderStatus::class, function (Faker $faker) {
    return [
        'order_id' => factory(\App\Models\Order::class),
        'paid_at' => $faker->dateTime(),
        'confirmed_at' => $faker->dateTime(),
        'processed_at' => $faker->dateTime(),
        'shipped_at' => $faker->dateTime(),
        'delivered_at' => $faker->dateTime(),
    ];
});
