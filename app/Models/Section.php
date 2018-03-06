<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Section
 * @package App\Models
 */
class Section extends Model
{

	/**
	 * @var array
	 */
	protected $guarded = ['id', 'created_at'];

	/**
	 * @return HasMany
	 */
	public function topics(): HasMany
	{
		return $this->hasMany(Topic::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function messages()
	{
		return $this->hasManyThrough(Message::class, Topic::class);
	}
}
