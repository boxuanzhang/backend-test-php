<?php

use Illuminate\Database\Seeder;

/**
 * Class AvatarSeeder
 */
class AvatarSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\App\Models\Avatar::truncate();

		factory(\App\Models\Avatar::class, 20)->create();
	}
}
