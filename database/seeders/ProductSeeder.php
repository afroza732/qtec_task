<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 50; $i++) {
            Product::create([
              'name' => $faker->word(15),
              'keyword' => $faker->word(10),
              'description' => $faker->sentence(),
              'price' => $faker->numberBetween($min= 100, $max=10000000),
              'stored_at' => $faker->randomDigit(),
              'in_stock' => $faker->randomDigit(),
              'image' => $faker->imageUrl($width=640, $height=200),
              'category_id' => $faker->randomElement(Category::pluck('id')),
               'user_id' => $faker->randomElement(User::pluck('id')),
            ]);
         }
    }
}
