<?php
/**
 * Laravel Classified
 *  All Rights Reserved
 *
 * 
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice
 * 
 */

namespace App\Http\Controllers\Search;

use Torann\LaravelMetaTags\Facades\MetaTag;

class TagController extends BaseController
{
	public $isTagSearch = true;
	public $tag;
	
	/**
	 * @param $countryCode
	 * @param null $tag
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index($countryCode, $tag = null)
	{
		// Check multi-countries site parameters
		if (!config('settings.seo.multi_countries_urls')) {
			$tag = $countryCode;
		}
		
		view()->share('isTagSearch', $this->isTagSearch);
		
		// Get Tag
		$this->tag = rawurldecode($tag);
		
		// Search
		$search = new $this->searchClass();
		$data   = $search->setTag($tag)->fetch();
		
		// Get Titles
		$bcTab     = $this->getBreadcrumb();
		$htmlTitle = $this->getHtmlTitle();
		view()->share('bcTab', $bcTab);
		view()->share('htmlTitle', $htmlTitle);
		
		// Meta Tags
		$title = $this->getTitle();
		MetaTag::set('title', $title);
		MetaTag::set('description', $title);
		
		// Translation vars
		view()->share('uriPathTag', $tag);
		
		return appView('search.serp', $data);
	}
}