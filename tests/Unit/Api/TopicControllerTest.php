<?php

namespace Tests\Unit\Api;

use App\Models\Topic;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicControllerTest extends TestCase
{

	/**
	 *
	 */
	public function testIndex()
	{
		$test_user = factory(User::class)->create();

		$this->actingAs($test_user, 'api');

		$response = $this->ajaxGet('/api/v1/topics/')
			->assertStatus(200)
			->assertJsonStructure([
				'*' => [
					'id',
					'title',
					'body',
					'owner_id',
					'owner_name',
					'owner_email',
					'owner_nickname',
					'owner_bio',
					'total_messages',
				]
			]);
	}

	/**
	 *
	 */
	public function testShow()
	{
		$test_user = factory(User::class)->create();

		$this->actingAs($test_user, 'api');

		$topic = factory(Topic::class)->create();

		$response = $this->ajaxGet('/api/v1/topics/' . $topic->id)
			->assertStatus(200)
			->assertJsonStructure([
				'id',
				'title',
				'body',
				'owner_id',
				'owner_name',
				'owner_email',
				'owner_nickname',
				'owner_bio',
				'total_messages',
			]);
	}
}
