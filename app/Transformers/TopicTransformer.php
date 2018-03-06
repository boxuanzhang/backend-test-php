<?php

namespace App\Transformer;

use App\Models\Topic;

class TopicTransformer extends Transformer
{

	/**
	 * @param $topic
	 * @return array
	 */
	public function transform($topic)
	{
		return [
			'id'             => $topic['id'],
			'title'          => $topic['title'],
			'body'           => $topic['body'],
			'owner_id'       => $topic['owner']['id'],
			'owner_name'     => $topic['owner']['name'],
			'owner_email'    => $topic['owner']['email'],
			'owner_nickname' => $topic['owner']['nickname'],
			'owner_bio'      => $topic['owner']['bio'],
			'total_messages' => Topic::find($topic['id'])->messages()->count(),
		];
	}
}