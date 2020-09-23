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
use App\Models\Field;
use App\Models\PostValue;

class PostValueObserver
{
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param PostValue $postValue
	 * @return void
	 */
	public function deleting(PostValue $postValue)
	{
		// Storage Disk Init.
		$disk = StorageDisk::getDisk();
		
		// Remove files (if exists)
		$field = Field::findTrans($postValue->field_id);
		if (!empty($field)) {
			if ($field->type == 'file') {
				if (
					!empty($postValue->value)
					&& $disk->exists($postValue->value)
				) {
					$disk->delete($postValue->value);
				}
			}
		}
	}
}
