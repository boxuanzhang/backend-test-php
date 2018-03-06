<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Transformer\SectionTransformer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class SectionController
 * @package App\Http\Controllers\Api
 */
class SectionController extends Controller
{

	/**
	 * @var SectionTransformer
	 */
	protected $sectionTransformer;

	/**
	 * SectionController constructor.
	 * @param $sectionTransformer
	 */
	public function __construct(SectionTransformer $sectionTransformer)
	{
		$this->sectionTransformer = $sectionTransformer;
	}


	/**
	 * @return array
	 */
	public function index()
	{
		return $this->sectionTransformer->transformCollection(Section::all()->toArray());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Section $section
	 * @return array
	 */
	public function show(Section $section)
	{
		return $this->sectionTransformer->transform($section->toArray());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return Section
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
		]);

		if (!Auth::user()->is_moderator) {
			abort(401);
		}

		return Section::create($request->all());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\Section $section
	 * @return Section
	 */
	public function update(Request $request, Section $section)
	{
		$section->update($request->all());

		return $section->fresh();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Section $section
	 * @throws \Exception
	 */
	public function destroy(Section $section)
	{
		$section->delete();
	}
}
