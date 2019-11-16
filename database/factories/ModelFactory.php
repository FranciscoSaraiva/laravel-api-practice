<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use App\Video;


$factory->define(Video::class, function(Faker\Generator $faker){
    $hash = $faker->swiftBicNumber(); //Because it looks like a hash ?
    return [
        'title' => $faker-> text(30),
        'description' => $faker->text(200),
        'hash' => $hash,
        'video_embed' => '//www.youtube.com/embed/'.$hash
    ];
});
