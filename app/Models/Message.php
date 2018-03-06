<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Builder;

/**
 * Class Message
 * @package App\Models
 */
class Message extends Model
{

	/**
	 * @var array
	 */
	protected $guarded = ['id', 'created_at'];

	/**
	 * @return BelongsTo
	 */
	public function owner(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	/**
	 * @return BelongsTo
	 */
	public function topic(): BelongsTo
	{
		return $this->belongsTo(Topic::class, 'topic_id');
	}

	/**
	 * @param $query
	 * @return mixed
	 */
	public function scopeRoot($query)
	{
		return $query->where('parent_id', 0);
	}

	/**
	 * @param $query
	 * @param $parent_id
	 * @return mixed
	 */
	public function scopeChildren($query, $parent_id)
	{
		return $query->where('parent_id', $parent_id);
	}
}
