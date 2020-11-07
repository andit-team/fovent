<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Upgrading
|--------------------------------------------------------------------------
|
| The upgrading process routes
|
*/
Route::group(['namespace' => 'App\Http\Controllers\Install', 'middleware' => ['web']], function () {
	Route::get('upgrade', 'UpdateController@index');
});


/*
|--------------------------------------------------------------------------
| Installation
|--------------------------------------------------------------------------
|
| The installation process routes
|
*/
Route::group([
	'namespace'  => 'App\Http\Controllers\Install',
	'middleware' => ['web'],
	'prefix'     => 'install',
], function () {
	Route::get('/', 'InstallController@starting');
	Route::get('site_info', 'InstallController@siteInfo');
	Route::post('site_info', 'InstallController@siteInfo');
	Route::get('system_compatibility', 'InstallController@systemCompatibility');
	Route::get('database', 'InstallController@database');
	Route::post('database', 'InstallController@database');
	Route::get('database_import', 'InstallController@databaseImport');
	Route::get('cron_jobs', 'InstallController@cronJobs');
	Route::get('finish', 'InstallController@finish');
});


/*
|--------------------------------------------------------------------------
| Back-end
|--------------------------------------------------------------------------
|
| The admin panel routes
|
*/
Route::group([
	'namespace'  => 'App\Http\Controllers\Admin',
	'middleware' => ['web'],
	'prefix'     => config('larapen.admin.route_prefix', 'admin'),
], function ($router) {
	// Auth
	// Authentication Routes...
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::get('logout', 'Auth\LoginController@logout')->name('logout');

	// Registration Routes...
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('register', 'Auth\RegisterController@register');

	// Password Reset Routes...
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
	
	// Admin Panel Area
	Route::group([
		'middleware' => ['admin', 'clearance', 'banned.user', 'prevent.back.history'],
	], function ($router) {
		// Dashboard
		Route::get('dashboard', 'DashboardController@dashboard');
		Route::get('/', 'DashboardController@redirect');
		
		// Extra (must be called before CRUD)
		Route::get('homepage/{action}', 'HomeSectionController@reset')->where('action', 'reset_(.*)');
		Route::get('languages/sync_files', 'LanguageController@syncFilesLines');
		Route::get('languages/texts/{lang?}/{file?}', 'LanguageController@showTexts');
		Route::post('languages/texts/{lang}/{file}', 'LanguageController@updateTexts');
		Route::get('permissions/create_default_entries', 'PermissionController@createDefaultEntries');
		Route::get('blacklists/add', 'BlacklistController@banUserByEmail');
		
		// CRUD
		CRUD::resource('advertisings', 'AdvertisingController');		
		CRUD::resource('blacklists', 'BlacklistController');
		CRUD::resource('categories', 'CategoryController');
		CRUD::resource('categories/{catId}/subcategories', 'SubCategoryController');
		CRUD::resource('categories/{catId}/custom_fields', 'CategoryFieldController');
		CRUD::resource('cities', 'CityController');
		CRUD::resource('countries', 'CountryController');
		CRUD::resource('countries/{countryCode}/cities', 'CityController');
		CRUD::resource('countries/{countryCode}/admins1', 'SubAdmin1Controller');
		CRUD::resource('currencies', 'CurrencyController');
		CRUD::resource('custom_fields', 'FieldController');
		CRUD::resource('custom_fields/{cfId}/options', 'FieldOptionController');
		CRUD::resource('custom_fields/{cfId}/categories', 'CategoryFieldController');
		CRUD::resource('genders', 'GenderController');
		CRUD::resource('homepage', 'HomeSectionController');
		CRUD::resource('admins1/{admin1Code}/cities', 'CityController');
		CRUD::resource('admins1/{admin1Code}/admins2', 'SubAdmin2Controller');
		CRUD::resource('admins2/{admin2Code}/cities', 'CityController');
		CRUD::resource('languages', 'LanguageController');
		CRUD::resource('meta_tags', 'MetaTagController');
		CRUD::resource('packages', 'PackageController');
		CRUD::resource('pages', 'PageController');
		CRUD::resource('payments', 'PaymentController');
		CRUD::resource('payment_methods', 'PaymentMethodController');
		CRUD::resource('permissions', 'PermissionController');
		CRUD::resource('pictures', 'PictureController');
		CRUD::resource('posts', 'PostController');
		CRUD::resource('p_types', 'PostTypeController');
		CRUD::resource('report_types', 'ReportTypeController');
		CRUD::resource('roles', 'RoleController');
		CRUD::resource('settings', 'SettingController');
		CRUD::resource('time_zones', 'TimeZoneController');

		Route::delete('users/delete/{id}', 'UserController@delete')->name('user.destroy');

		CRUD::resource('users', 'UserController');
		
		// Others
		Route::get('account', 'UserController@account');
		Route::post('ajax/{table}/{field}', 'InlineRequestController@make');
		
		// Backup
		Route::get('backups', 'BackupController@index');
		Route::put('backups/create', 'BackupController@create');
		Route::get('backups/download/{file_name?}', 'BackupController@download');
		Route::delete('backups/delete/{file_name?}', 'BackupController@delete')->where('file_name', '(.*)');
		
		// Actions
		Route::get('actions/clear_cache', 'ActionController@clearCache');
		Route::get('actions/clear_images_thumbnails', 'ActionController@clearImagesThumbnails');
		Route::post('actions/maintenance_down', 'ActionController@maintenanceDown');
		Route::get('actions/maintenance_up', 'ActionController@maintenanceUp');
		
		// Re-send Email or Phone verification message
		Route::get('verify/user/{id}/resend/email', 'UserController@reSendVerificationEmail');
		Route::get('verify/user/{id}/resend/sms', 'UserController@reSendVerificationSms');
		Route::get('verify/post/{id}/resend/email', 'PostController@reSendVerificationEmail');
		Route::get('verify/post/{id}/resend/sms', 'PostController@reSendVerificationSms');
		
		// Plugins
		Route::get('plugins', 'PluginController@index');
		Route::post('plugins/{plugin}/install', 'PluginController@install');
		Route::get('plugins/{plugin}/install', 'PluginController@install');
		Route::get('plugins/{plugin}/uninstall', 'PluginController@uninstall');
		Route::get('plugins/{plugin}/delete', 'PluginController@delete');





		/*
		|--------------------------------------------------------------------------
		| Some Word for next Developers
		|--------------------------------------------------------------------------
		|
		| I am Working on existing project as a new developer. The Previous developer useing Laravel backpack to develop it. But I see they didn't follow 
		| the rule of backpack which provide backpack doc. So I have to developed it with the laravel default system.
		|
		*/
        // Agent Ref User //

		CRUD::resource('user-agent', 'UserAgentConrtoller'); //-- Admin Panel
		CRUD::resource('user-sub-agent', 'UserSubAgentConrtoller'); //-- Admin Panel
		CRUD::resource('agent', 'AgentController'); //-- Admin Panel
		CRUD::resource('sub-agent', 'SubAgentController'); //-- Admin Panel


		Route::get('invitation','AgentController@invite');
		Route::get('my-user', 'AgentController@OwnRefUser');
		Route::get('sub-agent-user', 'SubAgentController@refAgentUserlist');
		Route::get('sub-agent-commission', 'SubAgentController@subAgentCommission');
		
		
		// Agent Commision //
		Route::get('payout/{id}', 'PayoutController@payoutForm');
		Route::post('payout/{id}', 'PayoutController@payoutFormSave');
		CRUD::resource('payouts', 'PayoutController');
		Route::get('agent-payout', 'PayoutController@agentPayout');
		Route::get('sub-agent-payout', 'PayoutController@subAgentPayout');
		CRUD::resource('agent-commission', 'AgentCommisionController');
		Route::get('agent-stripe', 'StripeAccountController@stripe');
		Route::get('setup-stripe', 'StripeAccountController@stripeSetup');
		Route::post('agent-stripe', 'StripeAccountController@stripeSave');

		// Route::get('user-agent', 'AgentController@refUser');
		// Route::get('user-sub-agent', 'SubAgentController@refAgentUser');

		
	});
});


/*
|--------------------------------------------------------------------------
| Front-end
|--------------------------------------------------------------------------
|
| The not translated front-end routes
|
*/
Route::group([
	'namespace'  => 'App\Http\Controllers',
	'middleware' => ['web'],
], function ($router) {
	// FILES
	Route::get('file', 'FileController@show');
	
	// SEO
	Route::get('sitemaps.xml', 'SitemapsController@index');
	
	// Impersonate (As admin user, login as an another user)
	Route::group(['middleware' => 'auth'], function ($router) {
		Route::impersonate();
	});
});


/*
|--------------------------------------------------------------------------
| Front-end
|--------------------------------------------------------------------------
|
| The translated front-end routes
|
*/
Route::group([
	'namespace'  => 'App\Http\Controllers',
	'middleware' => ['locale'],
	'prefix'     => LaravelLocalization::setLocale(),
], function ($router) {
	Route::group(['middleware' => ['web']], function ($router) {
		// HOMEPAGE
		Route::get('/', 'HomeController@index');
		Route::get(LaravelLocalization::transRoute('routes.countries'), 'CountriesController@index');
		
		
		// AUTH
		Route::group(['middleware' => ['guest', 'prevent.back.history']], function ($router) {
			// Registration Routes...
			Route::get(LaravelLocalization::transRoute('routes.register'), 'Auth\RegisterController@showRegistrationForm');
			Route::post(LaravelLocalization::transRoute('routes.register'), 'Auth\RegisterController@register');
			Route::get('register/finish', 'Auth\RegisterController@finish');
			
			// Authentication Routes...
			Route::get(LaravelLocalization::transRoute('routes.login'), 'Auth\LoginController@showLoginForm');
			Route::post(LaravelLocalization::transRoute('routes.login'), 'Auth\LoginController@login');
			
			// Forgot Password Routes...
			Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
			Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
			
			// Reset Password using Token
			Route::get('password/token', 'Auth\ForgotPasswordController@showTokenRequestForm');
			Route::post('password/token', 'Auth\ForgotPasswordController@sendResetToken');
			
			// Reset Password using Link (Core Routes...)
			Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
			Route::post('password/reset', 'Auth\ResetPasswordController@reset');
			
			// Social Authentication
			$router->pattern('provider', 'facebook|linkedin|twitter|google');
			Route::get('auth/{provider}', 'Auth\SocialController@redirectToProvider');
			Route::get('auth/{provider}/callback', 'Auth\SocialController@handleProviderCallback');
		});
		
		// Email Address or Phone Number verification
		$router->pattern('field', 'email|phone');
		Route::get('verify/user/{id}/resend/email', 'Auth\RegisterController@reSendVerificationEmail');
		Route::get('verify/user/{id}/resend/sms', 'Auth\RegisterController@reSendVerificationSms');
		Route::get('verify/user/{field}/{token?}', 'Auth\RegisterController@verification');
		Route::post('verify/user/{field}/{token?}', 'Auth\RegisterController@verification');
		
		// User Logout
		Route::get(LaravelLocalization::transRoute('routes.logout'), 'Auth\LoginController@logout');
		
		
		// POSTS
		Route::group(['namespace' => 'Post'], function ($router) {
			$router->pattern('id', '[0-9]+');
			// $router->pattern('slug', '.*');
			$router->pattern('slug', '^(?=.*)((?!\/).)*$');
			
			// SingleStep Post creation
			Route::group(['namespace' => 'CreateOrEdit\SingleStep'], function ($router) {
				Route::get('create', 'CreateController@getForm');
				Route::post('create', 'CreateController@postForm');
				Route::get('create/finish', 'CreateController@finish');
				
				// Payment Gateway Success & Cancel
				Route::get('create/payment/success', 'CreateController@paymentConfirmation');
				Route::get('create/payment/cancel', 'CreateController@paymentCancel');
				
				// Email Address or Phone Number verification
				$router->pattern('field', 'email|phone');
				Route::get('verify/post/{id}/resend/email', 'CreateController@reSendVerificationEmail');
				Route::get('verify/post/{id}/resend/sms', 'CreateController@reSendVerificationSms');
				Route::get('verify/post/{field}/{token?}', 'CreateController@verification');
				Route::post('verify/post/{field}/{token?}', 'CreateController@verification');
			});
			
			// MultiSteps Post creation
			Route::group(['namespace' => 'CreateOrEdit\MultiSteps'], function ($router) {
				Route::get('posts/create/{tmpToken?}', 'CreateController@getForm');
				Route::post('posts/create', 'CreateController@postForm');
				Route::put('posts/create/{tmpToken}', 'CreateController@postForm');
				Route::get('posts/create/{tmpToken}/photos', 'PhotoController@getForm');
				Route::post('posts/create/{tmpToken}/photos', 'PhotoController@postForm');
				Route::post('posts/create/{tmpToken}/photos/{id}/delete', 'PhotoController@delete');
				Route::get('posts/create/{tmpToken}/payment', 'PaymentController@getForm');
				Route::post('posts/create/{tmpToken}/payment', 'PaymentController@postForm');
				Route::get('posts/create/{tmpToken}/finish', 'CreateController@finish');
				
				// Payment Gateway Success & Cancel
				Route::get('posts/create/{tmpToken}/payment/success', 'PaymentController@paymentConfirmation');
				Route::get('posts/create/{tmpToken}/payment/cancel', 'PaymentController@paymentCancel');
				
				// Email Address or Phone Number verification
				$router->pattern('field', 'email|phone');
				Route::get('verify/post/{id}/resend/email', 'CreateController@reSendVerificationEmail');
				Route::get('verify/post/{id}/resend/sms', 'CreateController@reSendVerificationSms');
				Route::get('verify/post/{field}/{token?}', 'CreateController@verification');
				Route::post('verify/post/{field}/{token?}', 'CreateController@verification');
			});
			
			Route::group(['middleware' => 'auth'], function ($router) {
				$router->pattern('id', '[0-9]+');
				
				// SingleStep Post edition
				Route::group(['namespace' => 'CreateOrEdit\SingleStep'], function ($router) {
					Route::get('edit/{id}', 'EditController@getForm');
					Route::put('edit/{id}', 'EditController@postForm');
					
					// Payment Gateway Success & Cancel
					Route::get('edit/{id}/payment/success', 'EditController@paymentConfirmation');
					Route::get('edit/{id}/payment/cancel', 'EditController@paymentCancel');
				});
				
				// MultiSteps Post edition
				Route::group(['namespace' => 'CreateOrEdit\MultiSteps'], function ($router) {
					Route::get('posts/{id}/edit', 'EditController@getForm');
					Route::put('posts/{id}/edit', 'EditController@postForm');
					Route::get('posts/{id}/photos', 'PhotoController@getForm');
					Route::post('posts/{id}/photos', 'PhotoController@postForm');
					Route::post('posts/{token}/photos/{id}/delete', 'PhotoController@delete');
					Route::get('posts/{id}/payment', 'PaymentController@getForm');
					Route::post('posts/{id}/payment', 'PaymentController@postForm');
					
					// Payment Gateway Success & Cancel
					Route::get('posts/{id}/payment/success', 'PaymentController@paymentConfirmation');
					Route::get('posts/{id}/payment/cancel', 'PaymentController@paymentCancel');
				});
			});
			
			// Post's Details
			Route::get(LaravelLocalization::transRoute('routes.post'), 'DetailsController@index');
			
			// Contact Post's Author
			Route::post('posts/{id}/contact', 'DetailsController@sendMessage');
			
			// Send report abuse
			Route::get('posts/{id}/report', 'ReportController@showReportForm');
			Route::post('posts/{id}/report', 'ReportController@sendReport');
		});
		
		
		// ACCOUNT
		Route::group(['middleware' => ['auth', 'banned.user', 'prevent.back.history'], 'namespace' => 'Account'], function ($router) {
			$router->pattern('id', '[0-9]+');
			
			// Users
			Route::get('account', 'EditController@index');
			Route::group(['middleware' => 'impersonate.protect'], function () {
				Route::put('account', 'EditController@updateDetails');
				Route::put('account/settings', 'EditController@updateSettings');
				Route::put('account/preferences', 'EditController@updatePreferences');
				Route::post('account/{id}/photo', 'EditController@updatePhoto');
				Route::post('account/{id}/photo/delete', 'EditController@deletePhoto');
			});
			Route::get('account/close', 'CloseController@index');
			Route::group(['middleware' => 'impersonate.protect'], function () {
				Route::post('account/close', 'CloseController@submit');
			});
			
			// Posts
			Route::get('account/saved-search', 'PostsController@getSavedSearch');
			$router->pattern('pagePath', '(my-posts|archived|favourite|pending-approval|saved-search)+');
			Route::get('account/{pagePath}', 'PostsController@getPage');
			Route::get('account/my-posts/{id}/offline', 'PostsController@getMyPosts');
			Route::get('account/archived/{id}/repost', 'PostsController@getArchivedPosts');
			Route::get('account/{pagePath}/{id}/delete', 'PostsController@destroy');
			Route::post('account/{pagePath}/delete', 'PostsController@destroy');
			
			// Conversations
			Route::get('account/conversations', 'ConversationsController@index');
			Route::get('account/conversations/{id}/delete', 'ConversationsController@destroy');
			Route::post('account/conversations/delete', 'ConversationsController@destroy');
			Route::post('account/conversations/{id}/reply', 'ConversationsController@reply');
			$router->pattern('msgId', '[0-9]+');
			Route::get('account/conversations/{id}/messages', 'ConversationsController@messages');
			Route::get('account/conversations/{id}/messages/{msgId}/delete', 'ConversationsController@destroyMessages');
			Route::post('account/conversations/{id}/messages/delete', 'ConversationsController@destroyMessages');
			
			// Transactions
			Route::get('account/transactions', 'TransactionsController@index');
		});
		
		
		// AJAX
		Route::group(['prefix' => 'ajax'], function ($router) {
			Route::get('countries/{countryCode}/admins/{adminType}', 'Ajax\LocationController@getAdmins');
			Route::get('countries/{countryCode}/admins/{adminType}/{adminCode}/cities', 'Ajax\LocationController@getCities');
			Route::get('countries/{countryCode}/cities/{id}', 'Ajax\LocationController@getSelectedCity');
			Route::post('countries/{countryCode}/cities/autocomplete', 'Ajax\LocationController@searchedCities');
			Route::post('countries/{countryCode}/admin1/cities', 'Ajax\LocationController@getAdmin1WithCities');
			Route::post('category/sub-categories', 'Ajax\CategoryController@getSubCategories');
			Route::post('category/custom-fields', 'Ajax\CategoryController@getCustomFields');
			Route::post('save/post', 'Ajax\PostController@savePost');
			Route::post('save/search', 'Ajax\PostController@saveSearch');
			Route::post('post/phone', 'Ajax\PostController@getPhone');
			Route::post('post/pictures/reorder', 'Ajax\PostController@picturesReorder');
			Route::post('messages/check', 'Ajax\ConversationController@checkNewMessages');
		});
		
		
		// FEEDS
		Route::feeds();
		
		
		// Country Code Pattern
		$countryCodePattern = implode('|', array_map('strtolower', array_keys(getCountries())));
		$router->pattern('countryCode', $countryCodePattern);
		
		
		// XML SITEMAPS
		Route::get('{countryCode}/sitemaps.xml', 'SitemapsController@site');
		Route::get('{countryCode}/sitemaps/pages.xml', 'SitemapsController@pages');
		Route::get('{countryCode}/sitemaps/categories.xml', 'SitemapsController@categories');
		Route::get('{countryCode}/sitemaps/cities.xml', 'SitemapsController@cities');
		Route::get('{countryCode}/sitemaps/posts.xml', 'SitemapsController@posts');
		
		
		// STATICS PAGES
		Route::get(LaravelLocalization::transRoute('routes.page'), 'PageController@index');
		Route::get(LaravelLocalization::transRoute('routes.contact'), 'PageController@contact');
		Route::post(LaravelLocalization::transRoute('routes.contact'), 'PageController@contactPost');
		Route::get(LaravelLocalization::transRoute('routes.sitemap'), 'SitemapController@index');
		
		// DYNAMIC URL PAGES
		$router->pattern('id', '[0-9]+');
		$router->pattern('username', '[a-zA-Z0-9]+');
		Route::get(LaravelLocalization::transRoute('routes.search'), 'Search\SearchController@index');
		Route::get(LaravelLocalization::transRoute('routes.search-user'), 'Search\UserController@index');
		Route::get(LaravelLocalization::transRoute('routes.search-username'), 'Search\UserController@profile');
		Route::get(LaravelLocalization::transRoute('routes.search-tag'), 'Search\TagController@index');
		Route::get(LaravelLocalization::transRoute('routes.search-city'), 'Search\CityController@index');
		Route::get(LaravelLocalization::transRoute('routes.search-subCat'), 'Search\CategoryController@index');
		Route::get(LaravelLocalization::transRoute('routes.search-cat'), 'Search\CategoryController@index');
	});
});

use Twilio\Rest\Client;

Route::get('blabla/', function () {
	//sms
// 	require_once 'vendor/autoload.php';



// // Find your Account Sid and Auth Token at twilio.com/console
// // DANGER! This is insecure. See http://twil.io/secure
// $sid    = "ACa4926cfd41131893f382b741473f5383";
// $token  = "98f2e7115d1f48a196479afeb94c9693";
// $twilio = new Client($sid, $token);

// $message = $twilio->messages
//                   ->create("+8801969516500", // to
//                            ["body" => "Hi there! It's a test message from fovent", "from" => "+12348135586"]
//                   );

// dd($message);









	//stripe
	// require_once('C:\xampp\htdocs\blog7\vendor\stripe\stripe-php\lib\StripeClient.php');
	require_once('vendor/stripe/stripe-php/init.php');
	$stripe = new \Stripe\StripeClient(
	  'sk_test_4UFNwJyfZhmCwadehUkgD7kI'
	);

	//
	// $charge = $stripe->charges->create([ 
	// 	'amount'   => 1500,
	// 	'currency' => 'eur',
	// 	'source' => 'acct_1HeaZ3KKQxszX63y'
	//   ]);

	// $d = $stripe->charges->create([
	// 	'amount' => 2000,
	// 	'currency' => 'eur',
	// 	'source' => 'tok_amex',
	// 	'description' => 'My First Test Charge (created for API docs)',
	//   ]);

	//create a transfer
	// $d = $stripe->transfers->create([
	// 	'amount' => 100,
	// 	'currency' => 'eur',
	// 	'destination' => 'acct_1Hew2aLpwgOafOUt',
	// 	'transfer_group' => 'ORDER_95',
	// 	'source_transaction' => 'ch_1HedEXJofzftpf0daZQ087bm',
	// 	// "source_type" => "card"
	//   ]);
	  $d = $stripe->balance->retrieve();


dd($d);
// //create standerd account 
// $account = $stripe->accounts->create([
// 	'type' => 'standard',
//   ]);
//   dd($account);


	//Create an account 
	// $d = $stripe->accounts->create([
	// 	'type' => 'standard',
	// 	'country' => 'US',
	// 	'email' => 'anditkhulna2018@gmail.com',
	// 	'capabilities' => [
	// 	  'card_payments' => ['requested' => true],
	// 	  'transfers' => ['requested' => true],
	// 	],
	//   ]);

	  //create account link
	  $d = $stripe->accountLinks->create([
		'account' => 'acct_1Hew2aLpwgOafOUt',
		'refresh_url' => 'https://projects.andit.co/laravel/fovent/sRef',
		'return_url' => 'https://projects.andit.co/laravel/fovent/sRet',
		'type' => 'account_onboarding'
	  ]);
	  
	// $d = $stripe->tokens->create([
	// 	'card' => [
	// 	  'number' => '4242424242424242',
	// 	  'exp_month' => 10,
	// 	  'exp_year' => 2021,
	// 	  'cvc' => '314',
	// 	  'currency'=> 'eur'
	// 	],
	// 	]);
	  
	

	// $d=$stripe->accounts->createExternalAccount(
	// 	'acct_1HeeGiKapCtWr5Pb',
	// 	['external_account' => 'btok_1Heee7Jofzftpf0dXRTb7FwV']
	//   );
	  dd($d);
  
	//create a customer
	// $stripe->customers->create([
	//   'name'  => 'shariful',
	//   'description' => 'My First Test Customer (created for API docs)',
	// ]);
  
	// create bank account
// 	$token = $stripe->tokens->create([
// 	  'bank_account' => [
// 	    'country' => 'US',
// 	    'currency' => 'usd',
// 	    'account_holder_name' => 'Jenny Rosen',
// 	    'account_holder_type' => 'individual',
// 	    'routing_number' => '110000000',
// 	    'account_number' => '000123456789',
// 	  ],
// 	]);
	
// dd($token);
	// $stripe->customers->createSource(
	//   'cus_ICYiJznb1TD1Ap',
	//   ['source' => $token->id]
	// );

	//varify a bank account

	// $d = $stripe->customers->verifySource(
	// 	'cus_ICYiJznb1TD1Ap',
	// 	'ba_1Hc9j4Aqi3ZFd1dyhe2HlrTa',
	// 	['amounts' => [32, 45]]
	//   );

	  //payment

	//   $d = $stripe->paymentIntents->create([
	// 	'amount' => "200",
	// 	'currency' => 'usd',
	// 	'payment_method_types' => ['ach_debit'],
	// 	"capture_method"=> "automatic",
	// 	"confirm"=>"true",
	// 	"statement_descriptor"=>"asdf asdfadf",
	// 	"source"=>"ba_1Hc9j4Aqi3ZFd1dyhe2HlrTa",
	// 	"customer"=>"cus_ICYiJznb1TD1Ap",
	// 	"description"=>"asdf asdfadsf"
		
	//   ]);

	//create a card token
	// $d = $stripe->tokens->create([
	// 	'card' => [
	// 	  'number' => '4242424242424242',
	// 	  'exp_month' => 10,
	// 	  'exp_year' => 2021,
	// 	  'cvc' => '314',
	// 	],
	// 	]);


	//card payment

	//   $d = $stripe->paymentIntents->create([
	// 	'amount' => "250",
	// 	'currency' => 'usd',
	// 	'payment_method_types' => ['card'],
	// 	"capture_method"=> "automatic",
	// 	"confirm"=>"true",
	// 	"statement_descriptor"=>"asdf asdfadf",
	// 	"source"=>"card_1HcOsOAqi3ZFd1dyQ37LuTFO",
	// 	"customer"=>"cus_ICYiJznb1TD1Ap",
	// 	"description"=>"asdf asdfadsf"
		
	//   ]);


	//   dd($d);
  });

  Route::get('sRef',function(){
	echo 'refresh url';
  });
  Route::get('sRet',function(){
	echo 'Return url';
  });

