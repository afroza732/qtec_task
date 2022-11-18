<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            User::create([
              'name' => $faker->name,
              'name' => $faker->email,
            ]);
         }
    }
}
