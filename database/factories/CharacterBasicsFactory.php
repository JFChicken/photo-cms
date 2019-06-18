<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\CharacterBasics;
use Faker\Generator as Faker;


// photoshop sketch - phone app


$factory->define(CharacterBasics::class, function (Faker $faker) {
    return [
        //
        'userId' => 1,
        'characterName' => 'DM GAM-GAM',
        'characterJobTitle' => 'GM',
    ];

    
});
