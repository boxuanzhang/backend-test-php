<?php

namespace App\Transformer;

use Illuminate\Support\Facades\Storage;

/**
 * Class AvatarTransformer
 * @package App\Transformer
 */
class AvatarTransformer extends Transformer
{

	/**
	 * @param $avatar
	 * @return array
	 */
	public function transform($avatar)
	{
		$storage_type = env('STORAGE');
		$storage = Storage::disk($storage_type);

		return [
			'id'             => $avatar['id'],
			'filename'       => $avatar['filename'],
			'original_name'  => $avatar['original_name'],
			'size'           => $avatar['size'],
			'url'            => $storage->url($avatar['filename']),
			'owner_id'       => $avatar['owner']['id'],
			'owner_name'     => $avatar['owner']['name'],
			'owner_email'    => $avatar['owner']['email'],
			'owner_nickname' => $avatar['owner']['nickname'],
			'owner_bio'      => $avatar['owner']['bio'],
		];
	}
}