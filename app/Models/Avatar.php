<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{

	protected $guarded = ['id', 'created_at'];

	public function owner()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
