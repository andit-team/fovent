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

use App\Models\FieldOption;
use App\Models\PostValue;

class FieldOptionObserver extends TranslatedModelObserver
{
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param FieldOption $fieldOption
	 * @return void
	 */
	public function deleting($fieldOption)
	{
		parent::deleting($fieldOption);
		
		// Delete all translated entries
		$fieldOption->translated()->delete();
		
		// Delete all Posts Custom Field's Values
		$postValues = PostValue::where('value', $fieldOption->id)->get();
		if ($postValues->count() > 0) {
			foreach ($postValues as $value) {
				$value->delete();
			}
		}
	}
}
