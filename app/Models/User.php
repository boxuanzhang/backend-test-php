<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nickname',
        'bio',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

	/**
	 * @return HasMany
	 */
	public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

	/**
	 * @return HasMany
	 */
	public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

	/**
	 * @return HasMany
	 */
	public function avatars(): HasMany
	{
		return $this->hasMany(Avatar::class);
	}
}
