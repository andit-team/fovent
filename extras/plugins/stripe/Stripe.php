<?php

namespace extras\plugins\stripe;

use App\Helpers\Number;
use App\Models\Post;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Helpers\Payment;
use App\Models\Package;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;

class Stripe extends Payment
{
	/**
	 * Send Payment
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Post $post
	 * @return \App\Helpers\Payment|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	public static function sendPayment(Request $request, Post $post)
	{
		// Set URLs
		parent::$uri['previousUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], parent::$uri['previousUrl']);
		parent::$uri['nextUrl'] = str_replace(['#entryToken', '#entryId', '#title'], [$post->tmp_token, $post->id, slugify($post->title)], parent::$uri['nextUrl']);
		parent::$uri['paymentCancelUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], parent::$uri['paymentCancelUrl']);
		parent::$uri['paymentReturnUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], parent::$uri['paymentReturnUrl']);
		
		// Get the gateway token
		$token = $request->input('stripeToken');
		
		// Get the Package
		$package = Package::find($request->input('package_id'));
		
		// Don't make a payment if 'price' = 0 or null
		if (empty($package) || $package->price <= 0) {
			return redirect(parent::$uri['previousUrl'] . '?error=package')->withInput();
		}
		
		// API Parameters
		$providerParams = [
			'amount'   => Number::toFloat($package->price),
			'currency' => $package->currency_code,
			'token'    => $token,
		];
		
		// Local Parameters
		$localParams = [
			'payment_method_id' => $request->input('payment_method_id'),
			'cancelUrl'         => parent::$uri['paymentCancelUrl'],
			'returnUrl'         => parent::$uri['paymentReturnUrl'],
			'name'              => $package->name,
			'description'       => $package->name,
			'post_id'           => $post->id,
			'package_id'        => $package->id,
		];
		$localParams = array_merge($localParams, $providerParams);
		
		// Try to make the Payment
		try {
			$gateway = Omnipay::create('Stripe');
			$gateway->setApiKey(config('payment.stripe.secret'));
			
			// Make the payment
			$response = $gateway->purchase($providerParams)->send();
			
			// Get raw data
			$rawData = $response->getData();
			
			// Save the Transaction ID at the Provider
			if (isset($rawData['id'])) {
				$localParams['transaction_id'] = $rawData['id'];
			}
			
			// Save local parameters into session
			Session::put('params', $localParams);
			Session::save();
			
			// Payment by Credit Card when Card info are provide from the form.
			if ($response->isSuccessful()) {
				
				// Check if redirection to offsite payment gateway is needed
				if ($response->isRedirect()) {
					return $response->redirect();
				}
				
				// Apply actions after successful Payment
				return self::paymentConfirmationActions($localParams, $post);
				
			} elseif ($response->isRedirect()) {
				
				// Redirect to offsite payment gateway
				return $response->redirect();
				
			} else {
				
				// Apply actions when Payment failed
				return parent::paymentFailureActions($post, $response->getMessage());
				
			}
		} catch (\Exception $e) {
			
			// Apply actions when API failed
			return parent::paymentApiErrorActions($post, $e);
			
		}
	}
	
	/**
	 * @param $params
	 * @param $post
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public static function paymentConfirmation($params, $post)
	{
		// Set form page URL
		parent::$uri['previousUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], parent::$uri['previousUrl']);
		parent::$uri['nextUrl'] = str_replace(['#entryToken', '#entryId', '#title'], [$post->tmp_token, $post->id, slugify($post->title)], parent::$uri['nextUrl']);
		
		// Apply actions after successful Payment
		return parent::paymentConfirmationActions($params, $post);
	}
	
	/**
	 * @return array
	 */
	public static function getOptions()
	{
		$options = [];
		
		$paymentMethod = PaymentMethod::active()->where('name', 'stripe')->first();
		if (!empty($paymentMethod)) {
			$options[] = (object)[
				'name'     => mb_ucfirst(trans('admin.settings')),
				'url'      => admin_url('payment_methods/' . $paymentMethod->id . '/edit'),
				'btnClass' => 'btn-info',
			];
		}
		
		return $options;
	}
	
	/**
	 * @return bool
	 */
	public static function installed()
	{
		$paymentMethod = PaymentMethod::active()->where('name', 'stripe')->first();
		if (empty($paymentMethod)) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * @return bool
	 */
	public static function install()
	{
		// Remove the plugin entry
		self::uninstall();
		
		// Plugin data
		$data = [
			'id'                => 2,
			'name'              => 'stripe',
			'display_name'      => 'Stripe',
			'description'       => 'Payment with Stripe',
			'has_ccbox'         => 1,
			'is_compatible_api' => 0,
			'lft'               => 2,
			'rgt'               => 2,
			'depth'             => 1,
			'active'            => 1,
		];
		
		try {
			// Create plugin data
			$paymentMethod = PaymentMethod::create($data);
			if (empty($paymentMethod)) {
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * @return bool
	 */
	public static function uninstall()
	{
		$paymentMethod = PaymentMethod::where('name', 'stripe')->first();
		if (!empty($paymentMethod)) {
			$deleted = $paymentMethod->delete();
			if ($deleted > 0) {
				return true;
			}
		}
		
		return false;
	}
}
