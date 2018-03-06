<?php

namespace App\Repositories;

use App\Models\Message;
use App\Models\Topic;
use App\Transformer\MessageTransformer;

/**
 * Class TopicRepository
 * @package App\Repositories
 */
class TopicRepository
{

	/**
	 * @var Topic
	 */
	private $topic;
	/**
	 * @var MessageTransformer
	 */
	private $messageTransformer;

	/**
	 * TopicRepository constructor.
	 * @param $topic
	 * @param $messageTransformer
	 */
	public function __construct(Topic $topic, MessageTransformer $messageTransformer)
	{
		$this->topic = $topic;
		$this->messageTransformer = $messageTransformer;
	}

	/**
	 * @param $messages
	 * @return array
	 */
	public function outputMessages($messages)
	{
		$output = [];

		foreach ($messages->get() as $message) {
			$data = $this->messageTransformer->transform($message->toArray());
			$data['children'] = $this->outputMessages(Message::children($message->id)->with('owner'));
			$output[] = $data;
		}

		return $output;
	}

	/**
	 * @param Topic $topic
	 */
	public function approveTopic(Topic $topic)
	{
		$topic->is_approve = true;

		$topic->save();
	}
}
