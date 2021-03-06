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

class PreventBackHistory
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$response = $next($request);
		
		$headers = [
			'Cache-Control' => 'nocache, no-store, max-age=0, must-revalidate',
			'Pragma'        => 'no-cache',
			'Expires'       => 'Sun, 02 Jan 1990 00:00:00 GMT',
		];
		
		foreach ($headers as $key => $value) {
			$response->headers->set($key, $value);
		}
		
		return $response;
	}
}
