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

namespace App\Http\Controllers\Post\CreateOrEdit\Traits;

use App\Helpers\Ip;
use App\Models\Post;
use App\Models\Scopes\VerifiedScope;
use App\Models\User;
use App\Models\AgentCommision;
use App\Models\Agent;
use App\Notifications\SendPasswordAndEmailVerification;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Traits\CommissionTrait;
use Illuminate\Support\Facades\Http;

trait AutoRegistrationTrait
{
	use CommissionTrait;
	/**
	 * Auto Register a new user account.
	 *
	 * @param \App\Models\Post $post
	 * @return \App\Models\User|bool
	 */
	public function register(Post $post , $flag=0)
	{
		// Don't auto-register the User if he's logged in, ...
		// or when the 'auto_registration' option is disabled,
		// or when User uncheck the auto-registration checkbox.
		if (auth()->check() || config('settings.single.auto_registration') == 0 || !request()->filled('auto_registration')) {
			return false;
		}
		
		// Don't auto-register the User if Ad is empty, ...
		// or Email Address is not filled.
		if (empty($post) || empty($post->email)) {
			return false;
		}
		
		// Don't auto-register the User if his Email Address already exists
		$user = User::withoutGlobalScopes([VerifiedScope::class])->where('email', $post->email)->first();
		if (!empty($user)) {
			return false;
		}
		
		// AUTO-REGISTRATION
		
		// Conditions to Verify User's Email
		$emailVerificationRequired = config('settings.mail.email_verification') == 1 && !empty($post->email);
		
		// New User
		$user = new User();
		
		// Generate random password
		$randomPassword = getRandomPassword(8);
		$user->ip_info = Ip::getIpInformation();
		$user->country_code   = config('country.code');
		$user->language_code  = config('app.locale');
		$user->name           = $post->contact_name;
		$user->email          = $post->email;
		$user->password       = Hash::make($randomPassword);
		$user->phone          = $post->phone;
		$user->phone_hidden   = 0;
		$user->ip_addr        = Ip::get();
		$user->verified_email = 0;
		$user->verified_phone = 0;
		
		// Email verification key generation
		if ($emailVerificationRequired) {
			$user->email_token    = md5(microtime() . mt_rand());
			$user->verified_email = 0;
		}

		//Check Reference
		if(isset($_COOKIE['_ref'])){
			$agentVoucher = base64_decode($_COOKIE['_ref']);
			$agent = Agent::where('voucher_code',$agentVoucher)->with(['user.roles'])->first();
			$user->ref_type = $agent->user->roles[0]->name;
			$user->ref_id = $agent->user->id;
			setcookie("_ref", "", time() - 3600); // remove cookies
		}

		
		// Save
		$user->save();

		//update post user
		$post->user_id = $user->id;
		$post->save();
		
		// dd($user)
		//save commission if they are posted add.
		if($flag == 1){
			$this->commissionAdd($user,$post);
			// $agent = Agent::where('own_user_id',$user->ref_id)->first();
			// // dd($agent);
			// $commission = [
			// 	'agent_user_id' 		=> $user->ref_id,
			// 	'user_name'		 		=> $user->name,
			// 	'post_id'				=> $post->id,
			// 	'commision_percent'		=> $agent->commission,
			// 	'cost_of_post'			=> 0,
			// 	'commision'				=> 0,
			// 	'agent_type'			=> $user->ref_type,
			// 	'description'			=> $user->name.'| posted with 0 amount',
			// 	'currency'				=> 'EUR',
			// ];
			// AgentCommision::create($commission);
		}
		
		// Send Generated Password by Email
		try {
			$user->notify(new SendPasswordAndEmailVerification($user, $randomPassword));
		} catch (\Exception $e) {
			flash($e->getMessage())->error();
		}
		
		return $user;
	}
}
