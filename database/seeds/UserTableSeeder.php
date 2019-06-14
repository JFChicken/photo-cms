<?php

use App\User;
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
        $faker = Faker\Factory::create();

        $user = User::create([
            'name' => $faker->name,
            'email' => 'jfc@jfc.com',
            'password' => bcrypt('changeme'),
        ]);
    }
}
