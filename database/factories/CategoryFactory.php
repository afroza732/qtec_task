<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
		'name' => $this->faker->sentence(10),
		'description' => $this->faker->sentence(50),
		'created_at' => $this->faker->datetime(),
		'updated_at' => $this->faker->datetime(),
	];
});
