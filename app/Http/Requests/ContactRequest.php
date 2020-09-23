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
use App\Rules\BlacklistDomainRule;
use App\Rules\BlacklistEmailRule;
use App\Rules\EmailRule;

class ContactRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'first_name' => ['required', new BetweenRule(2, 100)],
			'last_name'  => ['required', new BetweenRule(2, 100)],
			'email'      => ['required', 'email', new EmailRule(), new BlacklistEmailRule(), new BlacklistDomainRule()],
			'message'    => ['required', new BetweenRule(5, 500)],
		];
		
		// reCAPTCHA
		$rules = $this->recaptchaRules($rules);
		
		return $rules;
	}
}
