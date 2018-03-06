<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Repositories\TopicRepository;
use App\Transformer\TopicTransformer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class TopicController
 * @package App\Http\Controllers\Api
 */
class TopicController extends Controller
{

	/**
	 * @var TopicRepository
	 */
	protected $topicRepository;
	protected $topicTransformer;

	/**
	 * TopicController constructor.
	 * @param $topicTransformer
	 */
	public function __construct(TopicTransformer $topicTransformer, TopicRepository $topicRepository)
	{
		$this->topicTransformer = $topicTransformer;
		$this->topicRepository = $topicRepository;
	}


	/**
	 * @return array
	 */
	public function index()
	{
		return $this->topicTransformer->transformCollection(Topic::with('owner')->get()->toArray());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Topic $topic
	 * @return array
	 */
	public function show(Topic $topic)
	{
		return $this->topicTransformer->transform(Topic::whereId($topic->id)->with('owner')->firstOrFail()->toArray());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @todo We should probably flag new topics for approval.
	 * @param  \Illuminate\Http\Request $request
	 * @return Topic
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'title' => 'required',
			'body'  => 'required',
		]);

		return Topic::create($request->all());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\Topic $topic
	 * @return Topic
	 */
	public function update(Request $request, Topic $topic)
	{
		if (Auth::user()->id !== $topic->user_id && !Auth::user()->is_moderator) {
			abort(401);
		}

		$topic->update($request->all());

		return $topic->fresh();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Topic $topic
	 * @throws \Exception
	 */
	public function destroy(Topic $topic)
	{
		$topic->delete();
	}

	/**
	 * @param Topic $topic
	 * @return array
	 */
	public function postApprove(Topic $topic)
	{
		$this->topicRepository->approveTopic($topic);

		return $this->show($topic);
	}
}
