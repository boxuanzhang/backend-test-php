<?php

namespace Tests\Unit\Api;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileControllerTest extends TestCase
{

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testShowUserProfile()
	{
		$test_user = factory(User::class)->create();

		$this->actingAs($test_user, 'api');

		$response = $this->ajaxGet('/api/v1/users/' . $test_user->id)
			->assertStatus(200)
			->assertJsonStructure([
				'id',
				'name',
				'email',
				'nickname',
				'bio',
				'created_at',
				'updated_at',
			]);

		$response = $this->ajaxGet('/api/v1/users/' . $test_user->id . '/profile/')
			->assertStatus(200)
			->assertJsonStructure([
				'id',
				'name',
				'email',
				'nickname',
				'bio',
				'created_at',
				'updated_at',
			]);
	}
}
