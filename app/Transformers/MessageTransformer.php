<?php

namespace App\Transformer;

/**
 * Class MessageTransformer
 * @package App\Transformer
 */
class MessageTransformer extends Transformer
{

	/**
	 * @param $messageCollection
	 * @return array
	 */
	public function transformCollection($messageCollection)
	{
		$messageCollection['data'] = array_map([$this, 'transform'], $messageCollection['data']);

		return $messageCollection;
	}

	/**
	 * @param $message
	 * @return array
	 */
	public function transform($message)
	{
		return [
			'id'             => $message['id'],
			'body'           => $message['body'],
			'created_at'     => $message['created_at'],
			'updated_at'     => $message['updated_at'],
			'is_highlight'   => (boolean) $message['is_highlight'],
			'owner_id'       => $message['owner']['id'],
			'owner_name'     => $message['owner']['name'],
			'owner_email'    => $message['owner']['email'],
			'owner_nickname' => $message['owner']['nickname'],
			'owner_bio'      => $message['owner']['bio'],
		];
	}
}