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

namespace App\Http\Requests;

use App\Rules\BetweenRule;
use App\Rules\EmailRule;

class ReportRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'report_type_id' => ['required', 'not_in:0'],
			'email'          => ['required', 'email', new EmailRule(), 'max:100'],
			'message'        => ['required', new BetweenRule(20, 1000)],
			'post_id'        => ['required', 'numeric'],
		];
		
		// reCAPTCHA
		$rules = $this->recaptchaRules($rules);
		
		return $rules;
	}
}
