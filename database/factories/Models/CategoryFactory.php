<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'parent_id' => $faker->word,
        'lft' => $faker->word,
        'rgt' => $faker->word,
        'depth' => $faker->word,
    ];
});
