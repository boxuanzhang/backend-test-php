<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Repositories\MessageRepository;
use App\Transformer\MessageTransformer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Debug\Tests\testHeader;

/**
 * Class MessageController
 * @package App\Http\Controllers\Api
 */
class MessageController extends Controller
{

	/**
	 * @var MessageTransformer
	 */
	protected $messageTransformer;
	/**
	 * @var MessageRepository
	 */
	protected $messageRepository;


	/**
	 * MessageController constructor.
	 * @param MessageTransformer $messageTransformer
	 * @param MessageRepository $messageRepository
	 */
	public function __construct(MessageTransformer $messageTransformer, MessageRepository $messageRepository)
	{
		$this->messageTransformer = $messageTransformer;
		$this->messageRepository = $messageRepository;
	}

	/**
	 * @return array
	 */
	public function index()
	{
		return $this->messageTransformer->transformCollection($this->messageRepository->getAllMessagesArray());
	}


	/**
	 * @param Message $message
	 * @return array
	 */
	public function show(Message $message)
	{
		return $this->messageTransformer->transform($message);
	}


	/**
	 * @param Request $request
	 * @return array
	 * @throws \Exception
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'topic_id' => 'required',
			'body'     => 'required',
		]);
		DB::beginTransaction();
		try {
			if ($request->parent_id) {
				if (Message::find($request->parent_id)->topic_id !== $request->topic_id) {
					throw new \DomainException("You shouldn't be able to link a message to a parent_id that doesn't share the same topic_id");
				}
			}
			$new_message = Message::create($request->all());
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}

		DB::commit();

		return $this->messageTransformer->transform($new_message);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\Message $message
	 * @return Message
	 */
	public function update(Request $request, Message $message)
	{
		if (Auth::user()->id != $message->user_id && !Auth::user()->is_moderator) {
			abort(401);
		}

		$message->update($request->all());

		return $message->fresh();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Message $message
	 * @throws \Exception
	 */
	public function destroy(Message $message)
	{
		$message->delete();
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postHighlight($id)
	{
		if (Message::find($id)->topic->user_id !== Auth::user()->id) {
			abort(401);
		}

		$this->messageRepository->highlightMessage($id);

		return response()->json([], 200);
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function postMarkBadMessage($id)
	{
		if (!Auth::user()->is_moderator) {
			abort(401);
		}
		$this->messageRepository->markBadMessage($id);

		return response()->json([], 200);
	}
}
