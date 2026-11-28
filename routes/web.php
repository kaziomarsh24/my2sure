<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/register/{from_ref_code?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register_user', 'Auth\RegisterController@register')->name('register_user');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('referralpage/{user_id?}', 'BankAccountController@referralpage')->name('referralpage');

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function(){

    require_once base_path('routes/admin.php');

});


Route::name('client.')->group(function(){

	Route::get('/', 'WelcomeController@index')->name('index');
	Route::get('/about', 'WelcomeController@about')->name('about');
	Route::get('/shop', 'ShopController@index')->name('shop');
	Route::get('/shop/{id}', 'ShopController@product_details')->name('product_details');
	Route::post('place_order', 'ShopController@place_order')->name('place_order');
    Route::get('orders', 'ShopController@my_orders')->name('my_orders');


	Route::get('/tos', 'WelcomeController@tos')->name('tos');
	Route::any('/how-to-play', fn () => redirect('/', 301));
	Route::get('/games', 'WelcomeController@play')->name('play');
	Route::get('/contact', 'WelcomeController@contact')->name('contact');
	Route::post('/contact/saveContact', 'WelcomeController@SendContact')->name('saveContact');


    Route::any('/giveawaydetail/{id?}', fn () => redirect('/', 301));
	Route::get('/giveawayadd', 'GamesController@giveawayadd')->name('giveawayadd');
    Route::get('/results', 'BoardController@results')->name('results');
    Route::get('/vip', 'BoardController@vip')->name('vip');

});
Route::middleware('auth:web')->name('client.')->group(function(){

	Route::post('games/savePlay', 'GamesController@savePlay')->name('games.savePlay');
	Route::resource('games','GamesController');

    Route::get('referralpage/{user_id?}', 'BankAccountController@referralpage')->name('referralpage');
    Route::post('add_bank_account', 'BankAccountController@saveBankdetails')->name('add_bank_account');

    Route::get('/competition', 'GamesController@giveaway')->name('giveaway');

    Route::get('/results', 'BoardController@results')->name('results');
    Route::get('/results/{id}', 'BoardController@resultShow')->name('results.show');
    Route::get('/vip', 'BoardController@vip')->name('vip');
    Route::get('/vip/{id}', 'BoardController@vipShow')->name('vip.show');
    Route::post('/board/comment/store', 'BoardCommentController@store')->name('board.comment.store');
    Route::post('/board/reply/store', 'BoardCommentController@replyStore')->name('board.reply.store');

    // Subscription gates
    Route::get('/vip-gate',       'SubscriptionController@vipGate')->name('vip.gate');
    Route::get('/twosure-gate',   'SubscriptionController@twoSureGate')->name('twosure.gate');
    Route::get('/allgames-gate',  'SubscriptionController@allGamesGate')->name('allgames.gate');
    Route::post('/subscription/success', 'SubscriptionController@handleSuccess')->name('subscription.success');
    Route::get('/vip-landing', 'SubscriptionController@vipLanding')->name('vip.landing');
    Route::get('/vip-subscribe/{duration}', 'SubscriptionController@vipSubscribe')->name('vip.subscribe');

    Route::post('/reward/pay', 'RewardController@pay')->name('reward.pay');
    Route::post('/board/like', 'BoardLikeController@toggle')->name('board.like');
});
Route::get('registerPay', 'PaymentController@index')->name('client.registerPay');
Route::get('subscribe', 'PaymentController@index')->name('client.subscribe');
Route::get('redirectPayment', 'PaymentController@redirectPayment')->name('client.redirectPayment');
Route::get('/detect-country', 'CountryController@detect')->name('detect.country');
Route::get('enableTrial', 'HomeController@enableTrial')->name('client.enableTrial');

// route for processing payment
Route::get('paypal', 'PaymentController@payWithpaypal')->name('client.payWithPaypal');

Route::get('payViaCreditCard', 'PaymentController@indexStripe')->name('client.payWithCard');
Route::post('payViaCreditCard', 'PaymentController@stripePost')->name('stripe.post');

// route for check status of the payment
Route::post('status', 'PaymentController@getPaymentStatus')->name('client.paymentStatus');
Route::post('comment/store', 'CommentController@store')->name('comment.store');
Route::post('reply/store','CommentController@replyStore')->name('reply.store');
