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

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CompatibleApiScope implements Scope
{
	/**
	 * Apply the scope to a given Eloquent query builder.
	 *
	 * @param Builder $builder
	 * @param Model $model
	 * @return $this|Builder
	 */
	public function apply(Builder $builder, Model $model)
	{
		// Load only the API Compatible entries for API call
		if (isFromApi()) {
			return $builder->where('is_compatible_api', 1);
		}
		
		// Load all entries for Web call
		return $builder;
	}
}
