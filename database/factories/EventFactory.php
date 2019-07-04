<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Events::class, function (Faker $faker) {
    return [
        // 'category_id' => $faker->unique()->randomNumber,
        'event_name' => $faker->text(50),
        'event_description' => $faker->text(200),
        'event_location' => $faker->text(50),
        'event_date' => $faker->date(),
        'event_host' => $faker->text(50),
        'event_time' => $faker->time(),
        'event_artists' => $faker->text(50),
        'event_poster' => $faker->text(50),
    ];
});
