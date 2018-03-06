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

$factory->define(App\Models\Avatar::class, function(Faker $faker) {
	return [
		'size'          => random_int(0, 100),
		'original_name' => $faker->name . 'jpg',
		'filename'      => substr(md5(microtime()), 0, 10) . '.jpg',
		'user_id'       => factory(\App\Models\User::class)->create()->id,
	];
});
