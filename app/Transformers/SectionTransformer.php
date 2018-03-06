<?php

namespace App\Transformer;

use App\Models\Section;

/**
 * Class SectionTransformer
 * @package App\Transformer
 */
class SectionTransformer extends Transformer
{

	/**
	 * @param $section
	 * @return array
	 */
	public function transform($section)
	{
		return [
			'id'             => $section['id'],
			'name'           => $section['name'],
			'created_at'     => $section['created_at'],
			'updated_at'     => $section['updated_at'],
			'total_messages' => Section::find($section['id'])->messages()->count(),
		];
	}
}