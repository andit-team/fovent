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

namespace App\Observer;

use App\Helpers\Files\Storage\StorageDisk;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class PageObserver extends TranslatedModelObserver
{
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param Page $page
	 * @return void
	 */
	public function deleting($page)
	{
		parent::deleting($page);
		
		// Storage Disk Init.
		$disk = StorageDisk::getDisk();
		
		// Delete the page picture
		if (!empty($page->picture)) {
			if (
				$page->translation_lang == config('appLang.abbr')
				&& $disk->exists($page->picture)
			) {
				$disk->delete($page->picture);
			}
		}
	}
	
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param Page $page
	 * @return void
	 */
	public function saved(Page $page)
	{
		// Removing Entries from the Cache
		$this->clearCache($page);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param Page $page
	 * @return void
	 */
	public function deleted(Page $page)
	{
		// Removing Entries from the Cache
		$this->clearCache($page);
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $page
	 */
	private function clearCache($page)
	{
		Cache::flush();
	}
}
