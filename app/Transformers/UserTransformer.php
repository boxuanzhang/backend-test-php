<?php

namespace App\Transformer;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserTransformer extends Transformer
{

	public function transform($user)
	{
		$avatar = User::find($user['id'])->avatars()->orderBy('created_at', 'desc')->first();
		$storage_type = env('STORAGE');
		$storage = Storage::disk($storage_type);

		return [
			'id'         => $user['id'],
			'name'       => $user['name'],
			'email'      => $user['email'],
			'nickname'   => $user['nickname'],
			'bio'        => $user['bio'],
			'created_at' => $user['created_at'],
			'updated_at' => $user['updated_at'],
			'avatar_url' => $avatar ? $storage->url($avatar['filename']) : null,
		];
	}
}