<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $faker = Faker\Factory::create();
            $user = new \App\User();
            $user->name = $faker->name;
            $user->username = $faker->userName;
            $user->email = $faker->email;
            $user->password = bcrypt('password');
            $user->save();
        }
    }
}
