<?php

use App\Models\CharacterBasics;
use Illuminate\Database\Seeder;

class CharacterBasicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $user = CharacterBasics::create([
            'userId' => 1,
            'characterName' => 'DM GAM-GAM',
            'characterJobTitle' => 'GM',
        ]);
    }
}
