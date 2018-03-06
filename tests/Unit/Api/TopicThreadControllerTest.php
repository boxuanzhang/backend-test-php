<?php

namespace Tests\Unit\Api;

use App\Models\Message;
use App\Models\Topic;
use App\Models\User;
use Tests\TestCase;

class TopicThreadControllerTest extends TestCase
{

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testGetTopicMessages()
	{
		$test_user = factory(User::class)->create();

		$this->actingAs($test_user, 'api');

		$topic = factory(Topic::class)->create();

		$message1 = factory(Message::class)->create([
			'topic_id'  => $topic->id,
			'parent_id' => 0,
		]);

		$message2 = factory(Message::class)->create([
			'topic_id'  => $topic->id,
			'parent_id' => 0,
		]);

		$message3_nested = factory(Message::class)->create([
			'topic_id'  => $topic->id,
			'parent_id' => $message2->id,
		]);

		$response = $this->ajaxGet('/api/v1/topics/' . $topic->id . '/thread')
			->assertStatus(200)
			->assertJsonStructure([
				'*' => [
					'body',
					'is_highlight',
					'owner_name',
					'owner_email',
					'owner_nickname',
					'owner_bio',
					'created_at',
					'updated_at',
					'children']
			]);
	}
}
