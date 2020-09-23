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

namespace App\Http\Requests\Admin;

class CityRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'name'      => ['required', 'min:2', 'max:255'],
			'asciiname' => ['required', 'min:2', 'max:255'],
			'latitude'  => ['required'],
			'longitude' => ['required'],
			'time_zone' => ['required'],
		];
		
		if (in_array($this->method(), ['POST', 'CREATE'])) {
			$rules['country_code'] = ['required', 'min:2', 'max:2'];
			$rules['subadmin1_code'] = ['required'];
		}
		
		return $rules;
	}
}
