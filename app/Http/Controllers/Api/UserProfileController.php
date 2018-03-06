<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformer\UserTransformer;
use Illuminate\Http\Request;

/**
 * Class UserProfileController
 * @package App\Http\Controllers\Api
 */
class UserProfileController extends Controller
{

	/**
	 * @var UserTransformer
	 */
	protected $userTransformer;

	/**
	 * UserProfileController constructor.
	 * @param $userTransformer
	 */
	public function __construct(UserTransformer $userTransformer)
	{
		$this->userTransformer = $userTransformer;
	}


	/**
	 * @param User $user
	 * @return array
	 */
	public function show(User $user)
	{
		return $this->userTransformer->transform($user->toArray());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @todo Only return fields appropriate to profile; nickname, bio etc.
	 * @todo Only the owning user should be able to update the profile.
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\User $user
	 * @return User
	 */
	public function update(Request $request, User $user)
	{
		$this->validate($request, [
			'nickname' => 'required|unique:users', // TODO: Check if unique
			'bio'      => 'required',
		]);

		if (Auth::user()->id != $user->id && !Auth::user()->is_moderator) {
			abort(401);
		}
		$user->update($request->all());

		return $this->userTransformer->transform($user);
	}
}
