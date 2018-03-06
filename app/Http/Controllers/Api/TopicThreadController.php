<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use App\Repositories\TopicRepository;

/**
 * Class TopicThreadController
 * @package App\Http\Controllers\Api
 */
class TopicThreadController extends Controller
{

	protected $topicRepository;

	/**
	 * TopicThreadController constructor.
	 * @param $topicRepository
	 */
	public function __construct(TopicRepository $topicRepository)
	{
		$this->topicRepository = $topicRepository;
	}


	/**
	 * Returns a nested "thread" of messages within the topic
	 *
	 * @param Topic $topic
	 * @return array
	 */
	public function show(Topic $topic)
	{
		return response()->json($this->topicRepository->outputMessages($topic->messages()->root()->with('owner')));
	}
}