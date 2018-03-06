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

$factory->define(App\Models\Message::class, function(Faker $faker) {
	$setIsHighlight = random_int(0, 2);

	return [
		'user_id'      => factory(\App\Models\User::class)->create()->id,
		'body'         => $faker->paragraph,
		'is_highlight' => $setIsHighlight ? true : false,
	];
});
