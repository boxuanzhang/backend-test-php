<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @package Tests
 */
abstract class TestCase extends BaseTestCase
{

	use CreatesApplication;

	/**
	 * @param string $url
	 * @param array $data
	 * @param array $headers
	 * @return \Illuminate\Foundation\Testing\TestResponse
	 */
	public function ajaxPost($url, array $data = [], $headers = [])
	{
		return $this->json('POST', $url, $data, $headers);
	}

	/**
	 * @param string $url
	 * @param array $data
	 * @param array $headers
	 * @return \Illuminate\Foundation\Testing\TestResponse
	 */
	public function ajaxPut($url, array $data = [], $headers = [])
	{
		return $this->json('PUT', $url, $data, $headers);
	}

	/**
	 * @param $url
	 * @param array $query
	 * @param array $headers
	 * @return \Illuminate\Foundation\Testing\TestResponse
	 */
	public function ajaxGet($url, array $query = [], $headers = [])
	{
		return $this->json('GET', $url, $query, $headers);
	}

	/**
	 * @return mixed
	 */
	public function actAsLoggedInUser()
	{
		$me = factory(User::class)->create();

		$this->actingAs($me, 'api');

		return $me;
	}

	/**
	 * @param $url
	 * @param array $query
	 * @param array $headers
	 * @return \Illuminate\Foundation\Testing\TestResponse
	 */
	public function ajaxDelete($url, array $query = [], $headers = [])
	{
		return $this->json('DELETE', $url, $query, $headers);
	}

	/**
	 * @param $response
	 * @return mixed
	 */
	public function responseAsArray($response)
	{
		return json_decode($response->content(), true);
	}
}
