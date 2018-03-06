<?php

namespace Tests\Unit\Api;

use App\Models\Message;
use App\Models\Topic;
use App\Models\User;
use Tests\TestCase;

class MessageControllerTest extends TestCase
{

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$test_user = factory(User::class)->create();

		$this->actingAs($test_user, 'api');

		$response = $this->ajaxGet('/api/v1/messages')
			->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					'*' => [
						'id',
						'body',
						'is_highlight',
						'owner_id',
						'owner_name',
						'owner_email',
						'owner_nickname',
						'owner_bio',
						'created_at',
						'updated_at',
					]
				],
				'current_page',
				'previous_page',
				'per_page',
				'total',
				'data',
				'next_page_url',
				'previous_page_url',
			]);
	}

	public function testShow()
	{
		$test_user = factory(User::class)->create();

		$this->actingAs($test_user, 'api');

		$test_message = factory(Message::class)->create([
			'topic_id'  => random_int(0, 10),
			'parent_id' => 0,
		]);

		$response = $this->ajaxGet('/api/v1/messages/' . $test_message->id)
			->assertStatus(200)
			->assertJsonStructure([
				'id',
				'body',
				'is_highlight',
				'owner_id',
				'owner_name',
				'owner_email',
				'owner_nickname',
				'owner_bio',
				'created_at',
				'updated_at',
			]);
	}

	public function testStore()
	{
		$me = factory(User::class)->create();
		$this->actingAs($me, 'api');

		$this->ajaxPost('/api/v1/messages', [
			'topic_id'     => random_int(0, 10),
			'body'         => str_random(10),
			'parent_id'    => 0,
			'is_highlight' => random_int(0, 2) ? true : false,
			'user_id'      => random_int(0, 10),
		])
			->assertStatus(200)
			->assertJsonStructure([
				'id',
				'body',
				'is_highlight',
				'owner_id',
				'owner_name',
				'owner_email',
				'owner_nickname',
				'owner_bio',
				'created_at',
				'updated_at',
			]);;
	}

	public function testHighlightMessage()
	{
		$me1 = factory(User::class)->create();
		$me2 = factory(User::class)->create();
		$this->actingAs($me1, 'api');

		$topic = factory(Topic::class)->create(['user_id' => $me2]);

		$message1 = factory(Message::class)->create([
			'topic_id'  => $topic->id,
			'parent_id' => 0,
		]);

		$this->ajaxPost('/api/v1/messages/' . $message1->id . '/highlight/', [])
			->assertStatus(401);

		$me3 = factory(User::class)->create();
		$this->actingAs($me3, 'api');

		$topic = factory(Topic::class)->create(['user_id' => $me3->id]);

		$message1 = factory(Message::class)->create([
			'topic_id'  => $topic->id,
			'parent_id' => 0,
		]);

		$this->ajaxPost('/api/v1/messages/' . $message1->id . '/highlight/', [])
			->assertStatus(200);
	}

	public function testMarkBadMessage()
	{
		$me = factory(User::class)->create(['is_moderator' => true]);
		$me2 = factory(User::class)->create(['is_moderator' => false]);

		$this->actingAs($me, 'api');

		$topic = factory(Topic::class)->create(['user_id' => $me->id]);

		$message1 = factory(Message::class)->create([
			'topic_id'  => $topic->id,
			'parent_id' => 0,
		]);

		$this->ajaxPost('/api/v1/messages/' . $message1->id . '/mark-bad/', [])
			->assertStatus(200);

		$this->actingAs($me2, 'api');
		$this->ajaxPost('/api/v1/messages/' . $message1->id . '/mark-bad/', [])
			->assertStatus(401);
	}
}
