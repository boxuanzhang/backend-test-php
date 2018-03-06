<?php

use Illuminate\Database\Seeder;

/**
 * Class MessageSeeder
 */
class MessageSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\App\Models\Message::truncate();

		$topic = factory(\App\Models\Topic::class)->create();

		for ($i = 0; $i < 20; $i++) {
			$this->helper(0, $topic->id);
		}
	}

	public function helper($parent_id = 0, $topic_id)
	{
		$hasChildren = random_int(0, 2);

		$message = factory(\App\Models\Message::class)->create([
			'topic_id'  => $topic_id,
			'parent_id' => $parent_id,
		]);

		if ($hasChildren) {
			$this->helper($message->id, $topic_id);
		}
	}
}
