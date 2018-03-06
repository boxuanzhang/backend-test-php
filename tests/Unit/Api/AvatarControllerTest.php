<?php

namespace Tests\Unit\Api;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvatarControllerTest extends TestCase
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

		$response = $this->ajaxGet('/api/v1/avatars/')
			->assertStatus(200)
			->assertJsonStructure([
				'*' => [
					'filename',
					'original_name',
					'size',
					'url',
					'owner_name',
					'owner_email',
					'owner_nickname',
					'owner_bio',
				]
			]);
	}

	public function testShowUpdateDelete()
	{
		$test_user = factory(User::class)->create();
		$this->actingAs($test_user, 'api');

		$response1 = $this->ajaxPost('/api/v1/avatars', [
			'avatar' => UploadedFile::fake()->image('avatar.jpg', 1, 1)->size(1)
		])
			->assertStatus(200)
			->assertJsonStructure([
				'id',
				'filename',
				'original_name',
				'size',
				'url',
				'owner_id',
				'owner_name',
				'owner_email',
				'owner_nickname',
				'owner_bio',
			]);
		Storage::disk('public')->assertExists($response1->original['filename']);


		$response2 = $this->ajaxDelete('/api/v1/avatars/' . $response1->original['id'])
			->assertStatus(200);
		Storage::disk('public')->assertMissing($response1->original['filename']);
	}
}
