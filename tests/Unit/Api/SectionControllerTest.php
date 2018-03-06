<?php

namespace Tests\Unit\Api;

use App\Models\Section;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class SectionControllerTest
 * @package Tests\Unit\Api
 */
class SectionControllerTest extends TestCase
{

	/**
	 *
	 */
	public function testIndex()
	{
		$test_user = factory(User::class)->create();

		$this->actingAs($test_user, 'api');

		$response = $this->ajaxGet('/api/v1/sections/')
			->assertStatus(200)
			->assertJsonStructure([
				'*' => [
					'id',
					'name',
					'created_at',
					'updated_at',
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

		$section = factory(Section::class)->create();

		$response = $this->ajaxGet('/api/v1/sections/' . $section->id)
			->assertStatus(200)
			->assertJsonStructure([
				'id',
				'name',
				'created_at',
				'updated_at',
				'total_messages',
			]);
	}
}
