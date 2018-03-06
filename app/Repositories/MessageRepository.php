<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

/**
 * Class MessageRepository
 * @package App\Repositories
 */
class MessageRepository
{

	/**
	 * @var Message
	 */
	private $message;

	/**
	 * TopicRepository constructor.
	 * @param $message
	 */
	public function __construct(Message $message)
	{
		$this->message = $message;
	}

	/**
	 * @return mixed
	 */
	public function getAllMessagesArray()
	{
		$messageCollection = $this->message->with('owner')->paginate(15);

		$temp['current_page'] = $messageCollection->currentPage();
		$temp['previous_page'] = $messageCollection->lastPage();
		$temp['per_page'] = $messageCollection->perPage();
		$temp['total'] = $messageCollection->total();
		$temp['data'] = $messageCollection->items();
		$temp['next_page_url'] = $messageCollection->nextPageUrl();
		$temp['previous_page_url'] = $messageCollection->previousPageUrl();

		return $temp;
	}


	/**
	 * @param $id
	 */
	public function highlightMessage($id)
	{
		$message = $this->message->findOrFail($id);

		$message->is_highlight = true;

		$message->save();
	}


	/**
	 * @param $id
	 */
	public function markBadMessage($id)
	{
		$message = $this->message->findOrFail($id);

		$message->is_bad = true;

		$message->save();
	}
}
