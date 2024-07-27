<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use Modules\Seo\Entities\Seo;
use Symfony\Component\HttpFoundation\Request;
class SeoBlocksComposer
{
	private $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function compose(View $view)
	{
		$view->with('seo_blocks', $this->getSeoBlocks());
	}

	private function getSeoBlocks()
	{
		$url = request()->path();
		
		$seo = Seo::where('url', $url)->first();

		$seoBlocks = array(
			'title' => isset($seo->title) ? $seo->title : '',
			'keywords' => isset($seo->keywords) ? $seo->keywords : '',
			'description' => isset($seo->description) ? $seo->description : '',
			'seo_text_title' => isset($seo->seo_text_title) ? $seo->seo_text_title : '',
			'seo_text_col1' => isset($seo->seo_text_col1) ? $seo->seo_text_col1 : '',
			'seo_text_col2' => isset($seo->seo_text_col2) ? $seo->seo_text_col2 : '',
			'audio' => isset($seo->audio) ? $seo->audio : '',
		);

		return $seoBlocks;
	}
}