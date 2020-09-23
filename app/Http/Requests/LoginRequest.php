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

use Illuminate\Support\Str;

class LoginRequest extends Request
{
	/**
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		// Don't apply this to the Admin Panel
		if (isFromAdminPanel()) {
			return;
		}
		
		$input = $this->all();
		
		// login (phone)
		if ($this->filled('login')) {
			$loginField = getLoginField($this->input('login'));
			if ($loginField == 'phone') {
				$input['login'] = phoneFormatInt($this->input('login'), $this->input('country_code', session('country_code')));
			}
		}
		
		request()->merge($input); // Required!
		$this->merge($input);
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		// If previous page is not the Login page...
		if (!Str::contains(url()->previous(), trans('routes.login'))) {
			// Save the previous URL to retrieve it after success or failed login.
			session()->put('url.intended', url()->previous());
		}
		
		$rules = [
			'login'    => ['required'],
			'password' => ['required'],
		];
		
		// reCAPTCHA
		$rules = $this->recaptchaRules($rules);
		
		return $rules;
	}
}
