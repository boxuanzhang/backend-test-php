<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Topic::class, function(Faker $faker) {
	return [
		'section_id' => factory(\App\Models\Section::class)->create()->id,
		'title'      => $faker->sentence,
		'body'       => $faker->paragraph,
		'user_id'    => factory(\App\Models\User::class)->create()->id,
	];
});
