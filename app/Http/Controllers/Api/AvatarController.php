<?php

namespace App\Http\Controllers\Api;

use App\Models\Avatar;
use App\Models\User;
use App\Transformer\AvatarTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{

	protected $avatarTransformer;

	/**
	 * AvatarController constructor.
	 * @param $avatarTransformer
	 */
	public function __construct(AvatarTransformer $avatarTransformer)
	{
		$this->avatarTransformer = $avatarTransformer;
	}

	public function index()
	{
		return $this->avatarTransformer->transformCollection(Avatar::with('owner')->get()->toArray());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		$storage_type = env('STORAGE');
		$storage = Storage::disk($storage_type);

		$file = $request->avatar;
		$original_name = $file->getClientOriginalName();
		$size = $file->getClientSize();

		$unique_name = substr(md5(microtime()), 0, 10) . '.' . $file->getClientOriginalExtension();

		$status = $storage->put($unique_name, file_get_contents($file));

//		For AWS S3
//		$status = Storage::disk('s3')->put($unique_name, file_get_contents($file), 'public');
//		$store_name = Storage::disk('s3')->url($unique_name);
//
		$data = null;

		if ($status) {
			$new_avatar = new Avatar;

			$new_avatar->user_id = Auth::user()->id;
			$new_avatar->filename = $unique_name;
			$new_avatar->original_name = $original_name;
			$new_avatar->size = $size;

			$new_avatar->save();

			$data = $this->avatarTransformer->transform(Avatar::whereId($new_avatar->id)->with('owner')->first()->toArray());
		}

		return response()->json($data, $status ? 200 : 400);
	}


	public function show(User $user)
	{
		$avatar = $user->avatars()->order_by('created_at', 'desc')->first();

		return response()->json($this->avatarTransformer->transform($avatar->with('owner')->toArray()));
	}

	public function update(Request $request)
	{
		$this->validate($request, [
			'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		$storage_type = env('STORAGE');
		$storage = Storage::disk($storage_type);

		$file = $request->avatar;
		$original_name = $file->getClientOriginalName();
		$size = $file->getClientSize();

		$unique_name = substr(md5(microtime()), 0, 10) . '.' . $file->getClientOriginalExtension();

		$status = $storage->put($unique_name, file_get_contents($file));

//		For AWS S3
//		$status = Storage::disk('s3')->put($unique_name, file_get_contents($file), 'public');
//		$store_name = Storage::disk('s3')->url($unique_name);

		$data = null;

		if ($status) {
			$new_avatar = new Avatar;

			$new_avatar->user_id = Auth::user()->id;
			$new_avatar->file_name = $unique_name;
			$new_avatar->original_name = $original_name;
			$new_avatar->size = $size;

			$new_avatar->save();

			$data = $this->avatarTransformer->transform($new_avatar->with('owner')->toArray());
		}

		return response()->json($data, $status ? 200 : 400);
	}

	public function destroy(Avatar $avatar)
	{
		$file = Avatar::findOrFail($avatar->id);
		$storage_type = env('STORAGE');
		Storage::disk($storage_type)->delete($avatar->filename);

		$avatar->delete();

		return response()->json([], 200);
	}
}
