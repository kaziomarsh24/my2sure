<?php


// \Auth::setDefaultDriver('admin'); //Setting Default Guard

use Illuminate\Support\Facades\Route;

Route::middleware('auth:web')->group(function(){

	Route::get('/home', 'LotteryController@index')->name('home');

    Route::get('users/search', 'UsersController@search')->name('users.search');

	Route::resource('general','GeneralController');
	Route::resource('games','GamesController');
    Route::post('save_schedule', 'GamesController@save_schedule')->name('save_schedule');
	Route::resource('shop','ShopController');
    Route::get('orders', 'ShopController@all_orders')->name('orders');
    Route::get('transactions', 'ShopController@transactions')->name('transactions');
	Route::resource('slider','SliderController');
	Route::get('/slideredit/{id}', 'SliderController@edit')->name('slideredit');
	Route::get('/sliderdestroy/{id}', 'SliderController@destroy')->name('sliderdestroy');
	Route::post('/sliderupdate', 'SliderController@Update')->name('sliderupdate');

	Route::resource('lottery','LotteryController');
	Route::resource('plans','PlansController');
	Route::resource('users','UsersController');
    Route::post('users/prediction', ['UserController@prediction'])->name('users.prediction');

	Route::resource('giveaway','GiveAwayController');
	Route::post('/updates', 'PlansController@updates')->name('updates');
	Route::get('/giveawayedit/{id}', 'GiveAwayController@edit')->name('giveawayedit');
	Route::post('/giveawayupdate', 'GiveAwayController@Update')->name('giveawayupdate');


	Route::resource('title','TitleController');
	Route::get('/titleedit/{id}', 'TitleController@edit')->name('titleedit');
	Route::post('/titleupdate', 'TitleController@Update')->name('titleupdate');

//    Route::resource('socialMediaLinks','SocialMediaLinkController');
    Route::get('/socialMediaLinksedit/{id}', 'SocialMediaLinkController@edit')->name('socialMediaLinksedit');
    Route::post('/socialMediaLinksupdate', 'SocialMediaLinkController@Update')->name('socialMediaLinksupdate');

    Route::post('/SendBulkEmail', 'UsersController@SendBulkEmail')->name('SendBulkEmail');

    Route::get('comments', 'AdminCommentController@index')->name('comments.index');
    Route::get('comments/{id}/edit', 'AdminCommentController@edit')->name('comments.edit');
    Route::post('comments/{id}/update', 'AdminCommentController@update')->name('comments.update');
    Route::get('comments/{id}/delete', 'AdminCommentController@destroy')->name('comments.destroy');


    // Result Posts
    Route::get('board/result', 'AdminBoardController@resultIndex')->name('board.result.index');
    Route::get('board/result/create', 'AdminBoardController@resultCreate')->name('board.result.create');
    Route::post('board/result/store', 'AdminBoardController@resultStore')->name('board.result.store');
    Route::get('board/result/{id}/edit', 'AdminBoardController@resultEdit')->name('board.result.edit');
    Route::post('board/result/{id}/update', 'AdminBoardController@resultUpdate')->name('board.result.update');
    Route::get('board/result/{id}/delete', 'AdminBoardController@resultDestroy')->name('board.result.destroy');
    Route::get('board/result/comments', 'AdminBoardController@resultComments')->name('board.result.comments');

// VIP Posts
    Route::get('board/vip', 'AdminBoardController@vipIndex')->name('board.vip.index');
    Route::get('board/vip/create', 'AdminBoardController@vipCreate')->name('board.vip.create');
    Route::post('board/vip/store', 'AdminBoardController@vipStore')->name('board.vip.store');
    Route::get('board/vip/{id}/edit', 'AdminBoardController@vipEdit')->name('board.vip.edit');
    Route::post('board/vip/{id}/update', 'AdminBoardController@vipUpdate')->name('board.vip.update');
    Route::get('board/vip/{id}/delete', 'AdminBoardController@vipDestroy')->name('board.vip.destroy');
    Route::get('board/vip/comments', 'AdminBoardController@vipComments')->name('board.vip.comments');

// Board Comments
    Route::get('board/comment/{id}/edit', 'AdminBoardController@commentEdit')->name('board.comment.edit');
    Route::post('board/comment/{id}/update', 'AdminBoardController@commentUpdate')->name('board.comment.update');
    Route::get('board/comment/{id}/delete', 'AdminBoardController@commentDestroy')->name('board.comment.destroy');

    Route::get('/source_plan', 'source_plan_conroller@index')->name('source_plan');
    Route::post('/source_plan_add', 'source_plan_conroller@add')->name('source_plan_add');
    Route::get('/delete_plan/{id}', 'source_plan_conroller@delete')->name('delete_plan');

    Route::get('subscriptions', 'AdminSubscriptionController@index')->name('subscriptions.index');
    Route::get('subscriptions/create', 'AdminSubscriptionController@create')->name('subscriptions.create');
    Route::post('subscriptions/store', 'AdminSubscriptionController@store')->name('subscriptions.store');
    Route::get('subscriptions/{id}/delete', 'AdminSubscriptionController@destroy')->name('subscriptions.destroy');
    Route::get('subscriptions/{id}/expire', 'AdminSubscriptionController@expire')->name('subscriptions.expire');

    Route::post('winners/mark', 'WinnersController@mark')->name('winners.mark');
    Route::get('winners', 'WinnersController@index')->name('winners.index');
    Route::get('winners/{id}/delete', 'WinnersController@destroy')->name('winners.destroy');


    Route::get('bulkEmail', function () {

        $passData = [
            "pageTitle" => "Write Email",

        ];
        return view('admin.users.sendEmail')->with($passData);

    })->name('bulkEmail');


});

