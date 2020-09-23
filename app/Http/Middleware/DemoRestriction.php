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

namespace App\Http\Middleware;

use Closure;
use Prologue\Alerts\Facades\Alert;

class DemoRestriction
{
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (isDemo()) {
			$message = t('demo_mode_message');
			
			if (isFromAdminPanel()) {
				Alert::info($message)->flash();
			} else {
				flash($message)->info();
			}
			
			return redirect()->back();
		}
		
		return $next($request);
	}
}
