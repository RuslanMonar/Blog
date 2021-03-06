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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Post::class, function (Faker\Generator $faker) {
    

    return [
        'title' => $faker->sentence,
        'content' => $faker->realText(5000),
        'image' => 'https://picsum.photos/id/'.rand(50 , 999).'/1920/1280.jpg',
        'date' => '16/07/20',
        'views' => $faker->numberBetween(0 , 5000),
        'description' => $faker->realText(500),
        'category_id' => 7,
        'user_id' => 1 ,
        'status' => 1,
        'is_featured' => 0 
    ];
});
$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
    ];
});
$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
    ];
});